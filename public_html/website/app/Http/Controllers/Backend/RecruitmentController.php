<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class RecruitmentController extends Controller
{
    public function __construct(Recruitment $recruitment)
    {
        $this->recruitment = $recruitment;
    }

    public function index()
    {
        if (request()->ajax()) {
            $data = $this->recruitment->all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-success btn-sm edit mr-1" data-action="' . route("recruitment-edit", $row->id) . '" data-toggle="modal" data-target="#editModel" data-backdrop="static" data-keyboard="false"><i class="fas fa-edit"></i></button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm delete"  data-action="' . route("recruitment-delete", $row->id) . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.recruitment.index');
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $recruitment = $this->recruitment;
            $recruitment->description = $request->description;
            $recruitment->status = $request->status;
            $recruitment->created_at = now();
            $recruitment->save();
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err->getMessage()]);
        }
        DB::commit();
        return response()->json(['success' => 'Recruitment process has been saved successfully!']);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $recruitment =  $this->recruitment->findOrFail($id);
            return view('backend.recruitment.edit_model', compact('recruitment'));
        }
    }

    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'description'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $recruitment = $this->recruitment->findOrFail((int) $id);
            $recruitment->description = $request->description;
            $recruitment->status = $request->status;
            $recruitment->created_at = now();
            $recruitment->save();
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err->getMessage()]);
        }
        DB::commit();
        return response()->json(['success' => 'Recruitment process has been updated successfully!']);
    }

    public function delete($id)
    {
        $recruitment =  $this->recruitment->findOrFail($id);
        $recruitment->delete();
        return response()->json('Recruitment has been deleted successfully!');
    }
}
