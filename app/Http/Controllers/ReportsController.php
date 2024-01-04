<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Employment;
class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unemployed = Employment::where('status', 'no')->with('user.alumni')->get();
        $total_unemployed = Employment::where('status', 'no')->count();
        $employed = Employment::where('status', 'yes')->with('user.alumni')->get();
        $total_employed = Employment::where('status', 'yes')->count();
        $courses = DB::table('alumnis')
        ->select('course', DB::raw('COUNT(*) as `count`'))
        ->groupBy('course')
        ->get();
        
        return response()->json(["unemployed" => $unemployed, "employed" => $employed, "total_unemployed" => $total_unemployed, "total_employed" => $total_employed, "courses" => $courses], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
