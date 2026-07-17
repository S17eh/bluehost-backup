<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutService;
use App\Models\AboutUs;
use App\Models\ContactUs;
use App\Models\CurrentOpening;
use App\Models\Home;
use App\Models\HomeImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class CMSController extends Controller
{
    protected $currentOpening;
    protected $home;
    protected $aboutUs;
    protected $aboutService;

    public function __construct(CurrentOpening $currentOpening, Home $home, AboutUs $aboutUs, AboutService $aboutService)
    {
        $this->currentOpening = $currentOpening;
        $this->home = $home;
        $this->aboutUs = $aboutUs;
        $this->aboutService = $aboutService;
    }

    /**********************************************************
     * Home Page Start
     **********************************************************/
    public function home()
    {
        $home = $this->home->find(1);
        $homeImage = HomeImage::first();
        return view('backend.home.view', compact('home', 'homeImage'));
    }

    public function homeEdit()
    {
        $home = $this->home->find(1);
        return view('backend.home.edit', compact('home'));
    }

    public function homeSave(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'description'  => 'required',
        ]);

        if ($request->file('image') != null) {
            $validator = Validator::make($request->all(), [
                'image'     => 'required|mimes:jpg,jpeg,png,gif',
            ]);
        }

        if ($validator->fails()) {
            return back()->withInput()->with('errors', $validator->errors());
        }

        DB::beginTransaction();
        try {
            $newData = [];
            $newData['title'] = $request->title;
            $newData['description'] = $request->description;
            if ($request->file('image') != null) {
                Storage::deleteDirectory('public/uploads/home');
                $name = $request->file('image')->hashName();
                $request->file('image')->store('public/uploads/home');
                $newData['image'] = $name;
            }
            $this->home->updateOrCreate(
                ['id' => '1'],
                $newData
            );
        } catch (Exception $err) {
            DB::rollBack();
            return back()->withInput()->with('error', $err);
        }
        DB::commit();
        return redirect()->route('home')->with('success', 'Home Details has been updated');
    }

    public function homeImageEdit()
    {
        $home = HomeImage::first();
        return view('backend.home.editImageSection', compact('home'));
    }

    public function homeImageSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'  => 'required',
            'description'  => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with('errors', $validator->errors());
        }

        DB::beginTransaction();
        try {
            $newData = [];
            $newData['title'] = $request->title;
            $newData['description'] = $request->description;
            $newData['created_at'] = now();

            HomeImage::updateOrCreate(
                ['id' => '1'],
                $newData
            );
        } catch (Exception $err) {
            DB::rollBack();
            return back()->withInput()->with('error', $err);
        }
        DB::commit();
        return redirect()->route('home')->with('success', 'Home Image Section Details has been updated');
    }

    /**********************************************************
     * Current Opening 
     **********************************************************/
    public function currentOpening()
    {
        if (request()->ajax()) {
            $data = $this->currentOpening->all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-success btn-sm edit mr-2" data-action="' . route("current-opening-edit", $row->id) . '" data-toggle="modal" data-target="#editModel" data-backdrop="static" data-keyboard="false"><i class="fas fa-edit"></i></button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm delete"  data-action="' . route("current-opening-delete", $row->id) . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.currentOpening.list');
    }

    public function currentOpeningSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|unique:current_openings|max:100',
            'description'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $currentOpening = $this->currentOpening;
            $currentOpening->title  = $request->title;
            $currentOpening->description  = $request->description;
            $currentOpening->status  = $request->status;
            $currentOpening->created_at  = now();
            $currentOpening->save();
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err]);
        }
        DB::commit();
        return response()->json(['success' => 'Current Opening has been saved successfully!']);
    }

    public function currentOpeningEdit($id)
    {
        $currentOpening = $this->currentOpening->findOrFail($id);
        return view('backend.currentOpening.partials.edit_model', compact('currentOpening'));
    }

    public function currentOpeningUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|unique:current_openings,id,' . $id . '|max:100',
            'description'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $currentOpening = $this->currentOpening->findOrFail((int) $id);
            $currentOpening->title  = $request->title;
            $currentOpening->description  = $request->description;
            $currentOpening->status  = $request->status;
            $currentOpening->created_at  = now();
            $currentOpening->save();
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err]);
        }
        DB::commit();
        return response()->json(['success' => 'Opening has been updated successfully!']);
    }

    public function currentOpeningDelete($id)
    {
        $this->currentOpening->find($id)->delete();
        return response()->json('Current Opening has been deleted successfully!');
    }

    /**********************************************************
     * About Us
     **********************************************************/
    public function aboutUs()
    {
        $aboutUs = $this->aboutUs->find(1);
        $aboutService = $aboutUs->aboutService;
        return view('backend.aboutUs.index', compact('aboutUs', 'aboutService'));
    }

    public function aboutUsEdit()
    {
        $aboutUs = $this->aboutUs->find(1);
        $aboutService = $aboutUs->aboutService;
        return view('backend.aboutUs.edit', compact('aboutUs', 'aboutService'));
    }

    public function aboutUsSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description'  => 'required',
        ]);

        if ($request->file('image') != null) {
            $validator = Validator::make($request->all(), [
                'image'     => 'required|mimes:jpg,jpeg,png,gif',
            ]);
        }

        if ($validator->fails()) {
            return back()->withInput()->with('errors', $validator->errors());
        }

        DB::beginTransaction();
        try {
            $newData = [];
            $newData['description'] = $request->description;
            if ($request->file('image') != null) {
                Storage::deleteDirectory('public/uploads/aboutUs');
                $name = $request->file('image')->hashName();
                $request->file('image')->store('public/uploads/aboutUs');
                $newData['image'] = $name;
            }

            $this->aboutUs->updateOrCreate(
                ['id' => '1'],
                $newData
            );

            $this->aboutService->where('about_us_id', 1)->delete();
            $newServiceData = [];
            $countCanDo = count($request->canDo);
            for ($i = 0; $countCanDo > $i; $i++) {
                $newRequest = $request->canDo[$i];
                $newServiceData[] = [
                    'about_us_id' => 1,
                    'service' => $newRequest,
                    'created_at' => now()
                ];
            }

            $this->aboutService->insert($newServiceData);
        } catch (Exception $err) {
            DB::rollBack();
            return back()->withInput()->with('error', $err);
        }
        DB::commit();
        return redirect()->route('about-us')->with('success', 'About Us Details has been updated');
    }



    // Contact us 
    public function contactUs()
    {
        $contactUs = ContactUs::pluck('value', 'meta');
        return view('backend.contactUs.index', compact('contactUs'));
    }


    public function contactUsEdit()
    {
        $contactUs = ContactUs::pluck('value', 'meta');
        return view('backend.contactUs.edit', compact('contactUs'));
    }

    public function contactUsSave(Request $request)
    {
        // dd($request->contact);
        DB::beginTransaction();
        try {
            if (sizeof($request->contact) > 0) {
                $contactUsData = $request->contact;
                foreach ($contactUsData as $key => $value) {
                    ContactUs::updateOrInsert(
                        ['meta' => $key],
                        ['value' => $value]
                    );
                }
            }
        } catch (Exception $err) {
            DB::rollBack();
            return back()->withInput()->with('error', $err);
        }
        DB::commit();
        return redirect()->route('contact-us')->with('success', 'Contact Us Details has been updated');
    }
}
