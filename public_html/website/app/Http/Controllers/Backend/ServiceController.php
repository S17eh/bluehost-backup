<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    protected $service;
    protected $service_type;

    public function __construct(Service $service, ServiceType $serviceType)
    {
        $this->service = $service;
        $this->service_type = $serviceType;
    }

    public function index()
    {
        $service = $this->service->find(1);
        $serviceType = $this->service_type->all();
        
        return view('backend.service.index', compact('service', 'serviceType'));
    }

    public function edit()
    {
        $service = $this->service->find(1);
        $serviceType = $this->service_type->all();

        return view('backend.service.edit', compact('service', 'serviceType'));
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title'  => 'required',
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
                Storage::deleteDirectory('public/uploads/service');
                $name = $request->file('image')->hashName();
                $request->file('image')->store('public/uploads/service');
                $newData['image'] = $name;
            }

            $this->service->updateOrCreate(
                ['id' => '1'],
                $newData
            );

            $this->service_type->query()->delete();
            $newServiceData = [];

            $countCanDo = count($request->serviceTitle);
            for ($i = 0; $countCanDo > $i; $i++) {
                $title = $request->serviceTitle[$i];
                $description = $request->serviceDescription[$i];
                $newServiceData[] = [
                    'title' => $title,
                    'description' => $description,
                    'order_no' => $i + 1,
                    'created_at' => now()
                ];
            }

            $this->service_type->insert($newServiceData);
        } catch (Exception $err) {
            return back()->withInput()->with('error', $err);
        }
        DB::commit();
        return redirect()->route('services')->with('success', 'Service Details has been updated');
    }
}
