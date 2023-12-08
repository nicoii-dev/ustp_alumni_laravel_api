<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
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
        Address::create([
            'user_id' => Auth::user()->id,
            'street' => $request['street'],
            'barangay' => $request['barangay'],
            'city_municipality' => $request['city_municipality'],
            'province' => $request['province'],
            'zipcode' => $request['zipcode'],
        ]);
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
        $validatedData = $request->validate([
            'street' => 'required',
            'barangay' => 'required',
            'city' => 'required',
            'province' => 'required',
            'region' => 'required',
            'zipcode' => 'required',
        ]);
        if($validatedData) {
            $address = Address::find($id);
            $address->street = $request->street;
            $address->barangay = $request->barangay;
            $address->city = $request->city;
            $address->province = $request->province;
            $address->region = $request->region;
            $address->zipcode = $request->zipcode;
            $address->save();

            return response()->json(['message' => 'Updated successfully'], 200);
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
