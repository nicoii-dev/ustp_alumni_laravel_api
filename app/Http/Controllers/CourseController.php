<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $course = Course::all();
        return response()->json(["data" => $course], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course' => 'required|unique:courses,course'
        ]);

        Course::create([
            'course' => $request['course'],
        ]);
        return response()->json(["message" => "Created successfully."], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::find($id);
        return response()->json(["data" => $course], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'course' => 'required'
        ]);

        $course = Course::where('course', $request['course'])
        ->where('id', '!=', $id)
        ->first();
        if($course !== null) {
            return response()->json(["message" => "This course is already been taken."], 422);
        };

        Course::where('id', $id)->update([
            'course' => $request['course'],
        ]);
        $course = Course::find($id);
        return response()->json(["message" => "Updated successfully.", "data" => $course], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
