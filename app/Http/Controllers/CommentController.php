<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\CommentImages;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('commentImages')->with('commentOwner')->orderBy('created_at', 'desc')->get();;
        return response()->json($comments, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required'
        ]);
        if($validatedData){
            try {
                $comment = new Comment();
                $comment->user_id = Auth::user()->id;
                $comment->post_id = $request->post_id;
                $comment->comment = $request->comment;
                $comment->save();
            if($request->hasFile('images')) {
                foreach ($request->file('images') as $imagefile) {
                    $image = new CommentImages();
                    $image->comment_id = $comment->id;
                    $path = $imagefile->store('/images/resource', ['disk' =>   'public']);
                    $image->url = $path;
                    $image->save();
                }
            }
                return response()->json(["message" => "Commented successfully."], 200);
            } catch(\Exception $e)
            {
                DB::rollBack();
                return response()->json(throw $e);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function showPostComments(string $id)
    {
        $comment = Comment::where('post_id', $id)->with('commentImages')->with('commentOwner')->orderBy('created_at', 'desc')->get();
        return response()->json($comment, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'post_id' => 'required'
        ]);
        if($validatedData){
            // delete images
            if($request->has('imagesToDelete')) {
                DB::table('comment_images')->whereIn('id', $request['imagesToDelete'])->delete();
            }
            try {
                $comment = Comment::find($id);
                $comment->comment = $request->comment;
                $comment->save();
            if($request->hasFile('images')) {
                foreach ($request->file('images') as $imagefile) {
                    $image = new CommentImages();
                    $image->comment_id = $comment->id;
                    $path = $imagefile->store('/images/resource', ['disk' =>   'public']);
                    $image->url = $path;
                    $image->save();
                }
            }
                return response()->json(["message" => "Commented successfully."], 200);
            } catch(\Exception $e)
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
        if(DB::table("comments")->where('id',$id)->delete()){
            $announcement = DB::table('comments')->get();
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }
}
