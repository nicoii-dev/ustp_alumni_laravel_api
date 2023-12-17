<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Achivement;

class AchivementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employment = Achivement::where("user_id", Auth::user()->id)->first();
        return response()->json( $employment, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $achivementData = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            // 'image' => 'required',
        ]);
        if($achivementData) {
            $achivement = new Achivement();
            $achivement->user_id = Auth::user()->id;
            $achivement->title = $request->title;
            $achivement->category = $request->category;
            $achivement->description = $request->description;
            $achivement->image = $request->image;
            $achivement->save();
            return response()->json(['message' => 'Created successfully'], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $achivement = Achivement::find($id);
        return response()->json($achivement, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'category' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        if($validatedData) {
            $education = Achivement::find($id);
            $education->college = $request->college;
            $education->college_address = $request->college_address;
            $education->course = $request->course;
            $education->college_sy = $request->college_sy;
            $education->save();

            return response()->json(['message' => 'Updated Successfully'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(DB::table("achivements")->where('id',$id)->delete()){
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }
}
