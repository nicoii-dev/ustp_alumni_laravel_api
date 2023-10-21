<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JobPosting;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = JobPosting::all();
        return response()->json(["data" => $jobs], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:job_postings,title',
            'description' => 'required',
            'images' => 'required'
        ]);

        JobPosting::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'images' => $request['images'],
        ]);

        return response()->json(["message" => "Created successfully."], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = JobPosting::find($id);
        return response()->json(["data" => $job], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $jobs = JobPosting::where('title', $request['title'])
        ->where('id', '!=', $id)
        ->first();
        if($jobs !== null) {
            return response()->json(["message" => "This title is already been taken."], 422);
        };

        JobPosting::where('id', $id)->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'images' => $request['images'],
        ]);
        $jobs = JobPosting::find($id);
        return response()->json(["message" => "Updated successfully.", "data" => $jobs], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(DB::table("job_postings")->where('id',$id)->delete()){
            $announcement = DB::table('job_postings')->get();
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }
}
