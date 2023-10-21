<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Like;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $likes = Like::all();
        return response()->json(["data" => $likes], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'post_id' => 'required',
            'number_of_likes' => 'required'
        ]);

        Like::create([
            'user_id' => Auth::user()->id,
            'post_id' => $request['post_id'],
            'number_of_likes' => $request['number_of_likes'],
        ]);

        return response()->json(["message" => "Created successfully."], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'number_of_likes' => 'required'
        ]);

        Like::where('id', $id)->update([
            'number_of_likes' => $request['number_of_likes'],
        ]);
        $likes = Like::find($id);
        return response()->json(["message" => "Updated successfully.", "data" => $likes], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
