<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class TeamController extends Controller
{
    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function index()
    {
        if (request()->ajax()) {
            $data = $this->team->all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return '<img src="' . asset('storage/uploads/team/' . $row->image) . '" width="100" height="100" >';
                })

                ->addColumn('action', function ($row) {
                    $editBtn = '<button class="btn btn-success btn-sm edit mr-1" data-action="' . route("team-edit", $row->id) . '" data-toggle="modal" data-target="#editModel" data-backdrop="static" data-keyboard="false"><i class="fas fa-edit"></i></button>';
                    $deleteBtn = '<button class="btn btn-danger btn-sm delete"  data-action="' . route("team-delete", $row->id) . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('backend.team.list');
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:50',
            'position'  => 'required',
            'image'     => 'required|mimes:jpg,jpeg,png,gif',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            // dd($request->file('image')->hashName());
            $name = $request->file('image')->hashName();
            $request->file('image')->store('public/uploads/team');

            $team = $this->team;
            $team->name = $request->name;
            $team->position = $request->position;
            $team->image = $name;
            $team->status = $request->status;
            $team->created_at = now();
            $team->save();
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err]);
        }
        DB::commit();
        return response()->json(['success' => 'Team member has been saved successfully!']);
    }

    public function edit($id)
    {
        $team =  $this->team->findOrFail($id);

        return view('backend.team.partials.edit_model', compact('team'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:50',
            'position'  => 'required',
            // 'image'     => 'required|mimes:jpg,jpeg,png,gif',
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

            $team = $this->team->findOrFail((int) $id);
            Storage::disk('public')->delete('uploads/team/' . $team->image);
            $team->name = $request->name;
            $team->position = $request->position;
            if ($request->file('image') != null) {
                $name = $request->file('image')->hashName();
                $request->file('image')->store('public/uploads/team');
                $team->image = $name;
            }
            $team->status = $request->status;
            $team->created_at = now();
            $team->save();
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['error' => $err]);
        }
        DB::commit();
        return response()->json(['success' => 'Team member has been updated successfully!']);
    }

    public function delete($id)
    {
        $team =  $this->team->findOrFail($id);
        Storage::disk('public')->delete('uploads/team/' . $team->image);
        $team->delete();
        return response()->json('Team has been deleted successfully!');
    }
}
