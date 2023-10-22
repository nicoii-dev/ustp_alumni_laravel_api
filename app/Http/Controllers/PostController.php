<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();
        return response()->json(["data" => $post], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|unique:posts,title'
        // ]);

        Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request['title'],
            'images' => $request['images'],
            'likes' => 0
        ]);

        return response()->json(["message" => "Created successfully."], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return response()->json(["data" => $post], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $request->validate([
        //     'title' => 'required'
        // ]);

        // $announcement = Announcement::where('title', $request['title'])
        // ->where('id', '!=', $id)
        // ->first();
        // if($announcement !== null) {
        //     return response()->json(["message" => "This title is already been taken."], 422);
        // };

        Post::where('id', $id)->update([
            'title' => $request['title'],
            'images' => $request['images'],
        ]);
        $post = Post::find($id);
        return response()->json(["message" => "Updated successfully.", "data" => $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(DB::table("posts")->where('id',$id)->delete()){
            $announcement = DB::table('posts')->get();
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }
}
