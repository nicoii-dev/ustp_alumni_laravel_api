<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Education;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $education = Education::where('user_id', Auth::user()->id)->get();
        return response()->json($education, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'college' => 'required',
            'college_address' => 'required',
            'course' => 'required',
            'college_sy' => 'required',
            'high_school' => 'required',
            'high_address' => 'required',
            'high_sy' => 'required',
            'elem_school' => 'required',
            'elem_address' => 'required',
            'elem_sy' => 'required',
        ]);
        if($validatedData) {
            $education = new Education();
            $education->user_id = Auth::user()->id;
            $education->college = $request->college;
            $education->college_address = $request->college_address;
            $education->course = $request->course;
            $education->college_sy = $request->college_sy;
            $education->high_school = $request->high_school;
            $education->high_address = $request->high_address;
            $education->high_sy = $request->high_sy;
            $education->elem_school = $request->elem_school;
            $education->elem_address = $request->elem_address;
            $education->elem_sy = $request->elem_sy;
            $education->save();

            return response()->json(['message' => 'Created successfully'], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $education = Education::find($id);
        return response()->json($education, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'college' => 'required',
            'college_address' => 'required',
            'course' => 'required',
            'college_sy' => 'required',
            'high_school' => 'required',
            'high_address' => 'required',
            'high_sy' => 'required',
            'elem_school' => 'required',
            'elem_address' => 'required',
            'elem_sy' => 'required',
        ]);
        if($validatedData) {
            $education = Education::find($id);
            $education->college = $request->college;
            $education->college_address = $request->college_address;
            $education->course = $request->course;
            $education->college_sy = $request->college_sy;
            $education->high_school = $request->high_school;
            $education->high_address = $request->high_address;
            $education->high_sy = $request->high_sy;
            $education->high_school = $request->high_school;
            $education->high_address = $request->high_address;
            $education->high_sy = $request->high_sy;
            $education->save();

            return response()->json(['message' => 'Updated Successfully'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
