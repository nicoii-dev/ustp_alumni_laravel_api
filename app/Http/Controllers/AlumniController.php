<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Alumni;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcement = Alumni::with('user.trainings', 'user.jobHistory', 'user.employment', 'user.address', 'user.education', 'user.achievements')->get();
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
        $user = Alumni::where('id', $id)->with('user.trainings', 'user.jobHistory', 'user.employment', 'user.address')->first();
        return response()->json($user, 200);
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
        if(DB::table("alumnis")->where('id',$id)->delete()){
            return response()->json(["message" => "Deleted successfully."], 200);
        }else{
            return response()->json(["message" => "Something went wrong. Unable to delete."], 500);
        }
    }

    public function importCSV(Request $request)
    {
        //get website password
        $request->validate([
            'csv_data' => 'required|string',
        ]);

        // delete all data first
        Alumni::truncate();
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
