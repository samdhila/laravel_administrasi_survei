<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;

use App\Models\User;

use Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    //============GET DATA FROM DATABASE INTO DATATABLE============
    public function index()
    {
        $city = City::with('user')->get();
        if (request()->ajax()) {
            return datatables()->of($city)
                ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" value="{{$id}}" class="checkbox" id="checkbox">')
                ->addColumn('surveyor', function (City $city) {
                    return $city->user->name;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    if ($row->done == 1 && $row->confirmed == 1) {
                        $btn = '<input type="button" value="Edit" href="javascript:void(0)" onClick="editFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit opacity-25" style="margin-right:10px" disabled>';
                        $btn = $btn . '<input type="button" value="Confirm" href="javascript:void(0)" onClick="confirmFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="Assign" class="assign btn btn-primary opacity-25" id="assign-surveyor" style="margin-right:10px" disabled>';
                    } else if ($row->done == 1 && $row->confirmed == 0) {
                        $btn = '<input type="button" value="Edit" href="javascript:void(0)" onClick="editFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit opacity-25" style="margin-right:10px" disabled>';
                        $btn = $btn . '<input type="button" value="Confirm" href="javascript:void(0)" onClick="confirmFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="Assign" class="assign btn btn-primary" id="assign-surveyor" style="margin-right:10px">';
                    } else if ($row->done == 0 && $row->confirmed == 0) {
                        $btn = '<input type="button" value="Edit" href="javascript:void(0)" onClick="editFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit" style="margin-right:10px">';
                        $btn = $btn . '<input type="button" value="Confirm" href="javascript:void(0)" onClick="confirmFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="Assign" class="assign btn btn-primary opacity-25" id="assign-surveyor" style="margin-right:10px" disabled>';
                    } else {
                        $btn = '<input type="button" value="Edit" href="javascript:void(0)" onClick="editFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success edit" style="margin-right:10px">';
                        $btn = $btn . '<input type="button" value="Confirm" href="javascript:void(0)" onClick="confirmFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="Assign" class="assign btn btn-primary" id="assign-surveyor" style="margin-right:10px">';
                    }

                    $btn = $btn . '<input type="button" value="Delete" href="javascript:void(0)" onClick="deleteFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger" id="delete-city">';
                    return $btn;
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        $data['users'] = User::role('user')->get(["id", "name"]);

        return view('admin-page', $data);
    }
    //============STORE DATA INTO MODAL============
    public function store(Request $request)
    {

        $cityId = $request->id;
        $user = new User();
        $city = City::with('user')->get();

        $city   =   City::updateOrCreate(
            [
                'id' => $cityId
            ],
            [
                'name' => $request->name,
                'population' => $request->population,
                'surveyor_id' => $request->surveyor_id
            ]
        );

        return Response()->json($city);
    }
    //============EDIT DATA USING MODAL============
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $city  = City::with('user')->where($where)->first();


        return Response()->json($city);
    }
    //============ FAST ASSIGN SURVEYOR BASED ON CHECKBOXES============
    public function fastAssign(Request $request)
    {
        $cityId = $request->cityId;
        foreach ($cityId as $key => $value) {
            $city = City::find($value);
            $city->surveyor_id = 3; // BETA
            $city->update();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Surveyor is successfully ASSIGNED'
        ]);
    }
    //============BATCH ASSIGN SURVEYOR BASED ON CHECKBOXES============
    public function batchAssign(Request $request)
    {
        $cityId = $request->cityId;
        $svrid = $request->svrid;
        foreach ($cityId as $key => $value) {
            $city = City::find($value);
            $city->surveyor_id = $svrid;
            $city->update();
        }

        return Response()->json($city);
    }
    //============BATCH UNASSIGN SURVEYOR BASED ON CHECKBOXES============
    public function batchUnassign(Request $request)
    {
        $cityId = $request->cityId;
        foreach ($cityId as $key => $value) {
            $city = City::find($value);
            $city->surveyor_id = null; //NULL
            $city->update();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Surveyor is successfully UNNASIGNED'
        ]);
    }
    //============BATCH CONFIRM DATA DONE BASED ON CHECKBOXES============
    public function batchConfirm(Request $request)
    {
        $cityId = $request->cityId;
        foreach ($cityId as $key => $value) {
            $city = City::find($value);
            $city->confirmed = 1; //CONFIRMED
            $city->update();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Some rows of data are CONFIRMED as DONE'
        ]);
    }
    //============CONFIRM A ROW OF DATA AS DONE============
    public function setConfirm(Request $request)
    {
        $id = $request->id;
        $city = City::find($id);
        $city->confirmed = 1; //DONE
        $city->update();

        return response()->json([
            'status' => 200,
            'message' => 'a row of data is CONFIRMED as DONE'
        ]);
    }
    //============BATCH DELETE DATA BASED ON CHECKBOXES============
    public function batchDelete(Request $request)
    {
        $cityId = $request->cityId;
        foreach ($cityId as $key => $value) {
            $city = City::find($value);
            $city->delete();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Some rows of data have DELETED'
        ]);
    }
    //============DELETE A ROW OF DATA============
    public function destroy(Request $request)
    {
        $city = City::where('id', $request->id)->delete();

        return Response()->json($city);
    }
}
