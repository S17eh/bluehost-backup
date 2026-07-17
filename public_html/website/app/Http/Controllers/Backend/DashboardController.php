<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CurrentOpening;
use App\Models\ResumeGenerate;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $teams = Team::count();
        $testimonials = Testimonial::count();
        $currentOpening = CurrentOpening::where('status', 'Active')->count();
        $yearlyGeneratedResumes = ResumeGenerate::whereYear('created_at', date('Y'))->count();
        $endDate = date('Y-m-d');
        $startDate = date('Y-m-01', strtotime(date('Y-m-01', strtotime('-1 year')) . '+1 month'));
        // dd(ResumeGenerate::whereDate('created_at', '>=',  $startDate)->whereDate('created_at', '<=',  $endDate)->get());
        $demoQuery = ResumeGenerate::whereDate('created_at', '>=',  $startDate)->whereDate('created_at', '<=',  $endDate)->get()->toArray();


        // Last 12 month Download resume chart data
        $time   = strtotime($startDate);
        $last   = date('M-Y', strtotime($endDate));
        $chartData['labels'] = [];
        $chartData['data'] = [];
        do {
            $m = date('m', $time);
            $y = date('Y', $time);
            $count = ResumeGenerate::whereMonth('created_at', $m)->whereYear('created_at', $y)->count();
            $chartData['labels'][] = date('M-Y', $time);
            $chartData['data'][] = $count;
            $month = date('M-Y', $time);
            $time = strtotime('+1 month', $time);
        } while ($month != $last);


        $resumes = ['1' => 'resume 1', '2' => 'resume 2', '3' => 'resume 3', '4' => 'resume 4', '5' => 'resume 5', '6' => 'resume 6', '7' => 'resume 7', '8' => 'resume 8', '9' => 'resume 9'];
        $resumeChart = [];
        foreach ($resumes as $key => $value) :
            $count = ResumeGenerate::where('resume_id', $key)->whereYear('created_at', date('Y'))->count();
            $resumeChart[] = [
                'label' => $value,
                'y' => $count,
            ];
        endforeach;

        return view('backend.dashboard.dashboard', compact('teams', 'testimonials', 'currentOpening', 'yearlyGeneratedResumes', 'chartData', 'resumeChart'));
    }

    public function profile()
    {
        $user = request()->session()->get('userCredential');
        return view('backend.dashboard.profile', compact('user'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'old_password'  => 'required|min:5|max:12',
            'password'  => 'required|min:5|max:12',
            'confirm_password'  => 'required|same:password',
        ]);
        $id = 1;
        $userInfo = User::findOrFail((int)$id);
        if (Hash::check($request->old_password, $userInfo->password)) {
            DB::beginTransaction();
            try {
                $userInfo->password = Hash::make($request->password);
                $userInfo->save();
            } catch (Exception $err) {
                DB::rollBack();
                return back()->withInput()->with('error', $err->getMessage());
            }
            DB::commit();
            return redirect()->route('profile')->with('success', 'Your password has been updated successfully.');
        } else {
            return back()->withInput()->with('error', 'Old Password is not match.');
        }
    }
}
