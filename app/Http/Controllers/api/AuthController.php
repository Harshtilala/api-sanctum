<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|string",
        ]);

        $user = User::where('email', $request->email)->first();

        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                $user->tokens()->delete();
                $token = $user->createToken("myToken", ['*'], now()->addHours(2))->plainTextToken;

                return response()->json([
                    'status' => 'true',
                    'message' => 'Logged In Successfully',
                    "expires_at" => now()->addHours(2)->toDateTimeString(),
                    'token' => $token
                ]);
            } else {
                return response()->json([
                    'status' => 'false',
                    'message' => 'Enter correct password'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'false',
                'message' => 'Invalid email'
            ]);
        }
    }
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|email",
            "password" => "required|string",
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'true',
            'message' => 'User Registed Successfully'
        ]);
    }
    public function profile(Request $request)
    {
        $userdata = auth()->user();

        return response()->json([
            'status' => 'true',
            'message' => 'User Registed Successfully',
            'data' => $userdata
        ]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'true',
            'message' => 'User Logged Out Successfully',
        ]);
    }
}
