<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcement = Announcement::all();
        return response()->json(["data" => $announcement], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:announcements,title'
        ]);

        Announcement::create([
            'title' => $request['title'],
            'announcement' => $request['announcement'],
            'images' => $request['images'],
        ]);
        $announcement = DB::table('announcements')->get();
        return response()->json(["message" => "Created successfully."], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $announcement = Announcement::find($id);
        return response()->json(["data" => $announcement], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $announcement = Announcement::where('title', $request['title'])
        ->where('id', '!=', $id)
        ->first();
        if($announcement !== null) {
            return response()->json(["message" => "This title is already been taken."], 422);
        };

        Announcement::where('id', $id)->update([
            'title' => $request['title'],
            'announcement' => $request['announcement'],
            'images' => $request['images'],
        ]);
        $announcement = Announcement::find($id);
        return response()->json(["message" => "Updated successfully.", "data" => $announcement], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(DB::table("announcements")->where('id',$id)->delete()){
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }
}
