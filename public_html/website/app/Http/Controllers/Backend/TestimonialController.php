<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TestimonialController extends Controller
{
    public function __construct(Testimonial $testimonial)
    {
        $this->testimonial = $testimonial;
    }


    public function index()
    {
        if (request()->ajax()) {
            $data = $this->testimonial->all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return '<img src="' . asset('storage/uploads/testimonial/' . $row->image) . '" width="100" height="100" >';
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-success btn-sm edit mr-1" data-action="' . route("testimonial-edit", $row->id) . '" data-toggle="modal" data-target="#editModel" data-backdrop="static" data-keyboard="false"><i class="fas fa-edit"></i></button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm delete"  data-action="' . route("testimonial-delete", $row->id) . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('backend.testimonial.index');
    }


    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:50',
            'position'  => 'required',
            'comment'   => 'required',
            'image'     => 'required|mimes:jpg,jpeg,png,gif',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $name = $request->file('image')->hashName();
            $request->file('image')->store('public/uploads/testimonial');

            $testimonial = $this->testimonial;
            $testimonial->name = $request->name;
            $testimonial->position = $request->position;
            $testimonial->image = $name;
            $testimonial->comment = $request->comment;
            $testimonial->status = $request->status;
            $testimonial->created_at = now();
            $testimonial->save();
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err->getMessage()]);
        }
        DB::commit();
        return response()->json(['success' => 'Testimonial has been saved successfully!']);
    }

    public function edit($id)
    {
        $testimonial = $this->testimonial->findOrFail($id);

        return view('backend.testimonial.partials.edit_model', compact('testimonial'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:50',
            'position'  => 'required',
            'comment'   => 'required',
        ]);

        if ($request->file('image') != null) {
            $validator = Validator::make($request->all(), [
                'image'     => 'required|mimes:jpg,jpeg,png,gif',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {

            $testimonial = $this->testimonial->findOrFail((int) $id);
            Storage::disk('public')->delete('uploads/testimonial/' . $testimonial->image);
            $testimonial->name = $request->name;
            $testimonial->position = $request->position;
            if ($request->file('image') != null) {
                $name = $request->file('image')->hashName();
                $request->file('image')->store('public/uploads/testimonial');
                $testimonial->image = $name;
            }
            $testimonial->comment = $request->comment;
            $testimonial->status = $request->status;
            $testimonial->created_at = now();
            $testimonial->save();
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err]);
        }
        DB::commit();
        return response()->json(['success' => 'Testimonial has been updated successfully!']);
    }

    public function delete($id)
    {
        $testimonial = $this->testimonial->findOrFail($id);
        Storage::disk('public')->delete('uploads/testimonial/' . $testimonial->image);
        $testimonial->delete();
        return response()->json('Testimonial has been deleted successfully!');
    }
}
