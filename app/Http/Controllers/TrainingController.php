<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Training;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $training = Training::all();
        return response()->json($training, 200);
    }

    public function getUserTraining()
    {
        $training = Training::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json($training, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'duration' => 'required',
        //     'institution' => 'required',
        // ]);
        foreach($request["data"] as $data){
            $trainingData = Training::where('user_id', Auth::user()->id)
            ->where('title', $data['title'])
            ->first();
            if($trainingData !== null) {
                return response()->json(["message" => "Training with this title is already saved."], 422);
            }
            Training::create([
                'user_id' => Auth::user()->id,
                'topic' => $data['topic'],
                'title' => $data['title'],
                'date' => $data['date'],
                'duration' => $data['duration'],
                'institution' => $data['institution'],
            ]);
        }
        return response()->json(["message" => "Created successfully."], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $training = Training::find($id);
        return response()->json($training, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'title' => 'required',
        //     'duration' => 'required',
        //     'institution' => 'required',
        // ]);
        foreach($request["data"] as $data){
            $trainingData = Training::where('user_id', Auth::user()->id)
            ->where('title', $data['title'])
            ->where('id', '!=', $id)
            ->first();
            if($trainingData !== null) {
                return response()->json(["message" => "Training with this title is already saved."], 422);
            }
            Training::where('id', $id)->update([
                'topic' => $data['topic'],
                'title' => $data['title'],
                'date' => $data['date'],
                'duration' => $data['duration'],
                'institution' => $data['institution'],
            ]);
            $training = Training::find($id);
            return response()->json(["message" => "Updated successfully.", "data" => $training], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(DB::table("trainings")->where('id',$id)->delete()){
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }
}
