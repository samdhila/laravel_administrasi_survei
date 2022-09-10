<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SurveyorController extends Controller
{
    //============GET DATA FROM DATABASE INTO DATATABLE============
    public function indexSurveyor()
    {
        $city = City::with('user')
            ->where('surveyor_id', '=', Auth::user()->id)
            ->where('confirmed', '=', 0)->get();

        if (request()->ajax()) {
            return datatables()->of($city)
                ->addColumn('checkbox', '<input type="checkbox" name="checkbox[]" value="{{$id}}" class="checkbox" id="checkbox">')
                ->addColumn('surveyor', function (City $city) {
                    return $city->user->name;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    if ($row->done == 1) {
                        $btn = '<input type="button" name="undone" value="unDone" href="javascript:void(0)" onClick="undoneFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="unDone" class="btn btn-warning undone">';
                    } else {
                        $btn = '<input type="button" name="done" value="Done" href="javascript:void(0)" onClick="doneFunc(' . $row->id . ')" data-toggle="tooltip" data-original-title="Done" class="btn btn-success done">';
                    }

                    return $btn;
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
        $data['users'] = User::role('user')->get(["id", "name"]);

        return view('surveyor-page', $data);
    }
    //============BATCH MARK AS DONE SOME ROWS============
    public function batchDone(Request $request)
    {
        $cityId = $request->cityId;
        foreach ($cityId as $key => $value) {
            $city = City::find($value);
            $city->done = 1; //DONE
            $city->update();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Some rows of data are marked as DONE'
        ]);
    }
    //============BATCH MARK AS UNDONE SOME ROWS============
    public function batchUndone(Request $request)
    {
        $cityId = $request->cityId;
        foreach ($cityId as $key => $value) {
            $city = City::find($value);
            $city->done = 0; //UNDONE
            $city->update();
        }

        return response()->json([
            'status' => 200,
            'message' => 'Some rows of data are marked as UNDONE'
        ]);
    }
    //============MARK AS DONE A ROW OF DATA============
    public function markDone(Request $request)
    {
        $id = $request->id;
        $city = City::find($id);
        $city->done = 1; //DONE
        $city->update();

        return response()->json([
            'status' => 200,
            'message' => 'a row of data is marked as DONE'
        ]);
    }
    //============MARK AS UNDONE A ROW OF DATA============
    public function markUndone(Request $request)
    {
        $id = $request->id;
        $city = City::find($id);
        $city->done = 0; //UNDONE
        $city->update();

        return response()->json([
            'status' => 200,
            'message' => 'a row of data is marked as UNDONE'
        ]);
    }
}
