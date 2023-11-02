<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Alumni;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcement = Alumni::all();
        return response()->json($announcement, 200);
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

    public function importCSV(Request $request)
    {
        //get website password
        $request->validate([
            'csv_data' => 'required|string',
        ]);
        $csvDatas = json_decode($request->csv_data);
        //insert data into database update if exists else insert
        foreach ($csvDatas as $data) {
            $alumni = Alumni::where([
                ['first_name', $data->first_name],
                ['middle_name', $data->middle_name],
                ['last_name', $data->last_name]
                ])->first();
            if ($alumni) {
                $alumni->first_name = $data->first_name;
                $alumni->middle_name = $data->middle_name;
                $alumni->last_name = $data->last_name;
                $alumni->course = $data->course;
                $alumni->year_graduated = $data->year_graduated;
                $alumni->save();
            } else {
                Alumni::create([
                    'first_name' => $data->first_name,
                    'middle_name' => $data->middle_name,
                    'last_name' => $data->last_name,
                    'course' => $data->course,
                    'year_graduated' => $data->year_graduated,
                ]);
            }
        }
        // Artisan::call('check:websites', []);
        return response()->json(["message" => "CSV Imported Successfully"], 200);
    }
}
