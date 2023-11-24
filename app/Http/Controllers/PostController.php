<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostImages;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::with('postImages')->with('postOwner')->orderBy('created_at', 'desc')->with('postLikes')->get();
        return response()->json($post, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|unique:posts,title'
        // ]);
        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->likes = 0;
        $post->save();
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $image = new PostImages();
                $image->post_id = $post->id;
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
        $post = Post::find($id);
        return response()->json($post, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if($request->has('imagesToDelete')) {
            DB::table('post_images')->whereIn('id', $request['imagesToDelete'])->delete();
        }
        $post = Post::find($id);
        $post->title = $request->title;
        $post->save();

        // add new images
        if($request->hasFile('images')) {
            foreach ($request->file('images') as $imagefile) {
                $image = new PostImages();
                $image->post_id = $post->id;
                $path = $imagefile->store('/images/resource', ['disk' =>   'public']);
                $image->url = $path;
                $image->save();
            }
        }
        $post = Post::find($id)->with('postImages')->with('postOwner')->with('postLikes')->get();
        return response()->json(["message" => "Updated successfully.", "data" => $post], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(DB::table("posts")->where('id',$id)->delete()){
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }
}
