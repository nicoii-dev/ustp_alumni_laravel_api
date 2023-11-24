<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $likes = Like::all();
        return response()->json($likes, 200);
    }

    public function showPostLikes(Request $request, string $id)
    {
        $likes = Post::where('id', $id)->first();
        return response()->json($likes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function likePost(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
        ]);
        Like::create([
            'user_id' => Auth::user()->id,
            'post_id' => $request['post_id'],
        ]);

        $postLikes = Post::where('id', $request['post_id'])->first();
        Post::where('id', $request['post_id'])->update([
            'likes' => $postLikes->likes + 1,
        ]);

        return response()->json(["message" => "Created successfully."], 200);
    }

    public function unLikePost(Request $request, $id)
    {

        $request->validate([
            'post_id' => 'required',
        ]);

        $postLikes = Post::where('id', $request['post_id'])->first();
        Post::where('id', $request['post_id'])->update([
            'likes' => $postLikes->likes - 1,
        ]);

        if(DB::table("likes")->where('id', $id)->delete()){
            return response()->json(["message" => "Unlike successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to unlike."], 500);
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
