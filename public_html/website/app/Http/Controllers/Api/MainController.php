<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ApplyJob;
use App\Mail\ContactUs;
use App\Models\AboutUs;
use App\Models\ContactUs as ModelsContactUs;
use App\Models\CorporateSolution;
use App\Models\CurrentOpening;
use App\Models\Home;
use App\Models\HomeImage;
use App\Models\Recruitment;
use App\Models\ResumeGenerate;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Team;
use App\Models\Testimonial;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function __construct(Home $home, CurrentOpening $currentOpening, Service $service, Recruitment $recruitment, ResumeGenerate $resumeGenerate)
    {
        $this->home = $home;
        $this->currentOpening = $currentOpening;
        $this->service = $service;
        $this->recruitment = $recruitment;
        $this->resumeGenerate = $resumeGenerate;
    }

    /*************************************************************
     * Current Opening
     *************************************************************/

    public function home()
    {
        $home = $this->home->find(1);
        $home->image = asset('storage/uploads/home/' . $home->image);

        $getTestimonial = Testimonial::where('status', 'Active')->get();
        $testimonial = [];
        foreach ($getTestimonial as $key => $item) {
            $testimonial[$key] = $item;
            $testimonial[$key]->image = asset('storage/uploads/testimonial/' . $item->image);
        }

        $homeImage = HomeImage::first();
        $output = [
            'home' => $home,
            'testimonial' => $testimonial,
            'homeImage' => $homeImage
        ];
        return response()->json($output);
    }

    /*************************************************************
     * Current Opening
     *************************************************************/
    public function currentOpening()
    {
        $openings =  $this->currentOpening->where('status', 'Active')->get();
        return response()->json($openings);
    }

    /*************************************************************
     * About Us
     *************************************************************/
    public function aboutUs()
    {
        $aboutUs = AboutUs::find(1);
        $aboutUs->image = asset('storage/uploads/aboutUs/' . $aboutUs->image);

        $getTeams = Team::where('status', 'Active')->get();
        $teams = [];
        foreach ($getTeams as $key => $team) {
            $teams[$key] = $team;
            $teams[$key]->image = asset('storage/uploads/team/' . $team->image);
        }

        $output = [
            'aboutUs' => $aboutUs,
            'aboutService' => $aboutUs->aboutService,
            'teams' => $teams
        ];
        return response()->json($output);
    }

    /**********************************************************
     * Services
     **********************************************************/
    public function services()
    {
        $service = $this->service->find(1);
        $service->image = asset('storage/uploads/service/' . $service->image);
        $serviceType = ServiceType::all();
        $corporateSolution = CorporateSolution::all();
        $recruitment = $this->recruitment->where('status', 'Active')->get();

        $output = [
            'service' => $service,
            'serviceType' => $serviceType,
            'recruitment' => $recruitment,
            'corporateSolution' => $corporateSolution,
        ];
        return response()->json($output);
    }


    /**********************************************************
     * Generate Resume PDF
     **********************************************************/
    public function generatePDF(Request $request)
    {

        if ($request['image'] == '') {
            $path =  public_path('pdf_placeholder.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $request['image'] = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        // $resumeID = '10';
        $resumeID = $request->resumeID;
        $resume = 'resume' . $resumeID;
        $pdf = Pdf::loadView('resumes.' . $resume, compact('request'))->setPaper('a4', 'Portrait')->setOptions(['dpi' => 140, 'defaultFont' => 'sans-serif']);
        // return $pdf->stream('resume.pdf');

        DB::beginTransaction();
        try {
            $resume = $this->resumeGenerate;
            $resume->resume_id =  $resumeID;
            $resume->ip_address = '129.0.1';
            $resume->lat = $request['lat'] ?? '';
            $resume->long = $request['long'] ?? '';
            $resume->created_at = now();
            $resume->save();
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err]);
        }
        DB::commit();

        $output = [
            'status' => 1,
            'status_code' => 200,
            'data' => 'data:application/pdf;base64,' . base64_encode($pdf->stream())
        ];
        return response()->json($output);
    }

    /**********************************************************
     * Send Mail
     **********************************************************/
    // Contact Us
    public function sendCountUsEmail(Request $request)
    {
        $res = Mail::to('vikramiphp@gmail.com')->send(new ContactUs($request));
        return response()->json(['success' => 'Send email successfully.']);
    }

    public function sendApplyJobEmail(Request $request)
    {
        $resume = explode(',', $request->resume);
        $fileName =  time() . '.' . 'pdf';
        Storage::disk('public')->put('temp_pdf/' . $fileName, base64_decode($resume[1]));
        $request->resume = asset('temp_pdf/' . $fileName);

        $newData = [
            "name" => $request->name,
            "email" => $request->email,
            "current_salary" => $request->current_salary,
            "expected_salary" => $request->expected_salary,
            "mobile_number" => $request->mobile_number,
            "experience_year" => $request->experience_year,
            "experience_month" => $request->month,
            "resume" => asset('storage/temp_pdf/' . $fileName)
        ];
        Mail::to($request['email'])->send(new ApplyJob($newData));
        $CheckFile = public_path('storage/temp_pdf/' . $fileName);
        if (File::exists($CheckFile)) {
            Storage::disk('public')->delete('temp_pdf/' . $fileName);
        }

        return response()->json(['success' => 'Send email successfully.']);
    }

    public function contactUs()
    {
        $contactUs = ModelsContactUs::pluck('value', 'meta');

        $output = $contactUs;
        return response()->json($output);
    }
}
