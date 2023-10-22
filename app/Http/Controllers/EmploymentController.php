<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Employment;

class EmploymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employment = Employment::all();
        return response()->json(["data" => $employment], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'type' => 'required'
        ]);

        Employment::create([
            'user_id' => Auth::user()->id,
            'status' => $request['status'],
            'type' => $request['type'],
        ]);
        return response()->json(["message" => "Created successfully."], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employment = Employment::find($id);
        return response()->json(["data" => $employment], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required',
            'type' => 'required'
        ]);

        Employment::where('id', $id)->update([
            'status' => $request['status'],
            'type' => $request['type'],
        ]);
        $employment = Employment::find($id);
        return response()->json(["message" => "Updated successfully.", "data" => $employment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(DB::table("employments")->where('id',$id)->delete()){
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }
}
