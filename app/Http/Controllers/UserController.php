<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Address;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    public function addProfileAddress(Request $request)
    {
        $validatedData = $request->validate([
            'civil_status' => 'required',
            'dob' => 'required',
            'street' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'region' => 'required',
            'zipcode' => 'required',
        ]);
        if($validatedData) {
            $user = User::find(Auth::user()->id);
            $user->civil_status = $request['civil_status'];
            $user->dob = $request['dob'];
            $user->save();
            $address = new Address();
            $address->user_id = Auth::user()->id;
            $address->street = $request->street;
            $address->barangay = $request->barangay;
            $address->city = $request->city;
            $address->province = $request->province;
            $address->region = $request->region;
            $address->zipcode = $request->zipcode;
            $address->save();

            return response()->json(['message' => 'Created successfully'], 200);
        }

    }

    public function activateUser($id)
    {
        $user = User::find($id);
        $user->status = 1;
        $user->save();
        return response()->json(['message' => 'User activated successfully'], 200);
    }

    public function deactivateUser($id)
    {
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        return response()->json(['message' => 'User deactivated successfully'], 200);
    }
}
