<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Mail\VerifyEmail;
use App\Models\User;
use App\Models\Alumni;
use App\Models\Address;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            // 'civil_status' => 'required|string|max:255',
            // 'dob' => 'required|string|max:255',
            // 'street' => 'required|string|max:255',
            // 'barangay' => 'required|string|max:255',
            // 'city' => 'required|string|max:255',
            // 'province' => 'required|string|max:255',
            // 'zipcode' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);

        $alumniData = Alumni::where('first_name', $request['first_name'])
        ->where('middle_name', $request['middle_name'])
        ->where('last_name', $request['last_name'])
        ->first();

        if($alumniData == null) {
            return response()->json(["message" => "No Alumni Record"], 500);
        } else {
            $alumni = User::create([
                'first_name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'gender' => $request['gender'],
                'phone_number' => $request['phone_number'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
                'role' => 'user',
                'status' => 1,
                'is_verified' => 0
            ]);
            $token = $alumni->createToken('MyApp')->plainTextToken;
            $link = "https://ustp-alumni-react-web-nicoii-dev.vercel.app/verify/$alumni->email/token=$token";
            Mail::to($alumni->email)->send(new VerifyEmail($alumni, $link));
            DB::commit();
            return response()->json([
                "message" => "Register successfully"
            ], 200);
        }

    }

    public function login(Request $request) {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Incorrect username or password.'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        if($user->is_verified == "1") {
            if($user->status == "1") {
                $response = [
                    'user' => $user,
                    'token' => $token,
                ];
            } else {
                return response(['message' => 'Account deactivated. Please contact administrator.'], 401);
            }
        } else {
            return response(['message' => 'Email is not verified.'], 401);
        }
        return response($response);
    }

    public function logout ()
    {
        if(isset(Auth::user()->id)){
            Auth::user()->tokens()->where('id', Auth::user()->currentAccessToken()->id)->delete();
            return response()->json([
                'status' => true
            ], 200);
        }else{
            return response()->json([
                'status' => false
            ], 401);
        }
    }

    public function verifyToken(Request $request)
    {
        if(isset(Auth::user()->id)){
            return response()->json([
                'status' => true
            ], 200);
        }else{
            return response()->json([
                'status' => false
            ], 401);
        }
    }

    public function verifyEmail(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
        ]);
        $user = User::where('email', $fields['email'])->first();
        if($user){
            $user->is_verified = true;
            $user->email_verified_at = now();
            $user->save();
            return response()->json([
                'message' => "Email verified"
            ], 200);
        }else{
            return response()->json([
                'message' => "Email not found"
            ], 404);
        }

    }

    public function changePassword(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'current_password' => 'required',
            'new_password' => 'required',
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['current_password'], $user->password)) {
            return response([
                'message' => 'Incorrect current password.'
            ], 401);
        }

        $user->password = Hash::make($fields['new_password']);
        $user->save();

        return response()->json(["message" => "Password updated successfully"], 200);
    }
}
