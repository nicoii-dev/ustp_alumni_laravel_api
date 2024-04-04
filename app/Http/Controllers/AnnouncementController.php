<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\AnnouncementImages;
use App\Models\PinnedAnnouncements;
class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcement = Announcement::with('announcementImages')->orderBy('created_at', 'desc')->get();
        return response()->json($announcement, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|unique:announcements,title',
            'announcement' => 'required'
        ]);
        if($validatedData){
            try {
            $announcement = new Announcement();
            $announcement->title = $request->title;
            $announcement->announcement = $request->announcement;
            $announcement->save();
            if($request->hasFile('images')) {
                foreach ($request->file('images') as $imagefile) {
                    $image = new AnnouncementImages();
                    $image->announcement_id = $announcement->id;
                    $path = $imagefile->store('/images/resource', ['disk' =>   'public']);
                    $image->url = $path;
                    $image->save();
                }
            }
            return response()->json(["message" => "Created successfully."], 200);
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
    public function show(string $id)
    {
        $announcement = Announcement::find($id);
        return response()->json($announcement, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'announcement' => 'required'
        ]);
        if($validatedData){
            $announcements = Announcement::where('title', $request['title'])
            ->where('id', '!=', $id)
            ->first();
            if($announcements != null) {
                return response()->json(["message" => "This title is already been taken."], 422);
            } else {
                // delete previous images
                if($request->has('imagesToDelete')) {
                    DB::table('announcement_images')->whereIn('id', $request['imagesToDelete'])->delete();
                }
                try {
                    $announcement = Announcement::find($id);
                    $announcement->title = $request->title;
                    $announcement->announcement = $request->announcement;
                    $announcement->save();
                    if($request->hasFile('images')) {
                        foreach ($request->file('images') as $imagefile) {
                            $image = new AnnouncementImages();
                            $image->announcement_id = $announcement->id;
                            $path = $imagefile->store('/images/resource', ['disk' =>   'public']);
                            $image->url = $path;
                            $image->save();
                        }
                    }
                    $announcements = Announcement::find($id);
                    return response()->json(["message" => "Updated successfully.", "data" => $announcements], 200);
                }catch(\Exception $e)
                {
                    DB::rollBack();
                    return response()->json(throw $e);
                }
            }
        }
    }

    public function showPinned()
    {
        $announcement = PinnedAnnouncements::where('user_id', '=', Auth::user()->id)->with('announcement')->with('announcementImages')->orderBy('created_at', 'desc')->get();
        return response()->json($announcement, 200);
    }

    public function pinned(string $id)
    {
        $pinnedAlready = PinnedAnnouncements::where('user_id', '=', Auth::user()->id)
        ->where('announcement_id', '=', $id)
        ->first();
        if($pinnedAlready != null) {
            return response()->json(["message" => "This announcement is already pinned."], 422);
        } else {
            $announcement = new PinnedAnnouncements();
            $announcement->announcement_id = $id;
            $announcement->user_id = Auth::user()->id;
            $announcement->save();
            return response()->json('Pinned successfully.', 200);
        }
    }

    public function unpinned(string $id)
    {
        if(DB::table("pinned_announcements")->where('id',$id)->delete()){
            return response()->json(["message" => "Unpinned successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
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
