<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Alumni;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $citationByMonth = CitationInfo::query()
        // ->select(\DB::raw("count(*) as total, DATE_FORMAT(date_of_violation, '%m') as month"))
        // ->groupByRaw('MONTHNAME(date_of_violation)')
        // ->orderBy('date_of_violation', 'ASC')
        // ->get();
        $users = User::where('role', '!=', 'admin')->count();
        $alumni = Alumni::all()->count();
        $active = User::where('role', '!=', 'admin')->where('status', 1)->count();
        $deactivated = User::where('status', 0)->count();
        $courses = DB::table('alumnis')
            ->select('course', DB::raw('COUNT(*) as `count`'))
            ->groupBy('course')
            ->having('count', '>', 1)
            ->get();

        return response()->json(["users" => $users, "course" => $courses,  "alumni" => $alumni, 'active' => $active, 'deactivated' => $deactivated], 200);
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
        //
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
