<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JobPosting;
use App\Models\JobPostingImages;

class JobPostingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = JobPosting::with('jobImages')->orderBy('created_at', 'desc')->get();
        return response()->json($post, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $job = new JobPosting();
        $job->title = $request->title;
        $job->description = $request->description;
        $job->save();
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $image = new JobPostingImages();
                $image->job_posting_id = $job->id;
                $path = $imagefile->store('/images/resource', ['disk' =>   'public']);
                $image->url = $path;
                $image->save();
            }
        }
        return response()->json(["message" => "Created successfully."], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = JobPosting::find($id);
        return response()->json($job, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $jobs = JobPosting::where('title', $request['title'])
        ->where('id', '!=', $id)
        ->first();
        if($jobs != null) {
            return response()->json(["message" => "This title is already been taken."], 422);
        } else {
            try {
                $job = JobPosting::find($id);
                $job->title = $request->title;
                $job->description = $request->description;
                $job->save();
                if($request->hasFile('images')) {
                    // delete previous images
                    DB::table('job_posting_images')->where('job_posting_id', $id)->delete();
                    foreach ($request->file('images') as $imagefile) {
                        $image = new JobPostingImages();
                        $image->job_posting_id = $job->id;
                        $path = $imagefile->store('/images/resource', ['disk' =>   'public']);
                        $image->url = $path;
                        $image->save();
                    }
                }
                $jobs = JobPosting::find($id);
                return response()->json(["message" => "Updated successfully.", "data" => $jobs], 200);
            }catch(\Exception $e)
            {
                DB::rollBack();
                return response()->json(throw $e);
            }
        }
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
