<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CorporateSolution;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CorporateSolutionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = CorporateSolution::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-success btn-sm edit mr-1" data-action="' . route("corporate-solution-edit", $row->id) . '" data-toggle="modal" data-target="#editModel" data-backdrop="static" data-keyboard="false"><i class="fas fa-edit"></i></button>';
                    return $editBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.corporateSolution.index');
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $corporation = CorporateSolution::findOrFail($id);
            return view('backend.corporateSolution.edit_model', compact('corporation'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $recruitment = CorporateSolution::findOrFail((int) $id);
            $recruitment->title = $request->title;
            $recruitment->description = $request->description;
            $recruitment->updated_at = now();
            $recruitment->save();
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err->getMessage()]);
        }
        DB::commit();
        return response()->json(['success' => 'Corporate solution has been updated successfully!']);
    }
}
