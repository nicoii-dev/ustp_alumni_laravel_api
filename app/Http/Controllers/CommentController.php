<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return response()->json(["data" => $comments], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'comment' => 'required'
        ]);

        Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $request['post_id'],
            'comment' => $request['comment'],
            'images' => $request['images'],
        ]);

        return response()->json(["message" => "Created successfully."], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::find($id);
        return response()->json(["data" => $comment], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        Comment::where('id', $id)->update([
            'comment' => $request['comment'],
            'images' => $request['images'],
        ]);
        $comment = Comment::find($id);
        return response()->json(["message" => "Updated successfully.", "data" => $comment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(DB::table("comments")->where('id',$id)->delete()){
            $announcement = DB::table('comments')->get();
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }
}
