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
        return response()->json(["data" => $training], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'duration' => 'required',
            'institution' => 'required',
        ]);

        $trainingData = Training::where('user_id', Auth::user()->id)
        ->where('title', $request['title'])
        ->first();

        if($trainingData !== null) {
            return response()->json(["message" => "Training with this title is already saved."], 200);
        }

        Training::create([
            'user_id' => Auth::user()->id,
            'title' => $request['title'],
            'duration' => $request['duration'],
            'institution' => $request['institution'],
        ]);
        return response()->json(["message" => "Created successfully."], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $training = Training::find($id);
        return response()->json(["data" => $training], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'duration' => 'required',
            'institution' => 'required',
        ]);

        $training = Training::where('title', $request['title'])
        ->where('user_id', Auth::user()->id)
        ->where('id', '!=', $id)
        ->first();

        if($training !== null) {
            return response()->json(["message" => "Training with this title is already saved."], 422);
        };

        Training::where('id', $id)->update([
            'title' => $request['title'],
            'duration' => $request['duration'],
            'institution' => $request['institution'],
        ]);
        $training = Training::find($id);
        return response()->json(["message" => "Updated successfully.", "data" => $training], 200);
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
