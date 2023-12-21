<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JobHistory;

class JobHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobHistory = JobHistory::where('user_id', Auth::user()->id)->get();
        return response()->json($jobHistory, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'company' => 'required',
            'position' => 'required',
            'date_started' => 'required',
            'date_ended' => 'required',
            'salary' => 'required',
            'status' => 'required',
        ]);
        if($validatedData) {
            $jobHistory = new JobHistory();
            $jobHistory->user_id = Auth::user()->id;
            $jobHistory->company = $request->company;
            $jobHistory->position = $request->position;
            $jobHistory->date_started = $request->date_started;
            $jobHistory->date_ended = $request->date_ended;
            $jobHistory->salary = $request->salary;
            $jobHistory->status = $request->status;
            $jobHistory->save();

            return response()->json(['message' => 'Created successfully'], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobHistory = JobHistory::find($id);
        return response()->json($jobHistory, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'company' => 'required',
            'position' => 'required',
            'date_started' => 'required',
            'date_ended' => 'required',
            'salary' => 'required',
            'status' => 'required',
        ]);
        if($validatedData) {
            $jobHistory = JobHistory::find($id);
            $jobHistory->company = $request->company;
            $jobHistory->position = $request->position;
            $jobHistory->date_started = $request->date_started;
            $jobHistory->date_ended = $request->date_ended;
            $jobHistory->salary = $request->salary;
            $jobHistory->status = $request->status;
            $jobHistory->save();

            return response()->json(['message' => 'Updated Successfully'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(DB::table("job_histories")->where('id',$id)->delete()){
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }
}
