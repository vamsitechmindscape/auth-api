<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate(([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]));
        $user = User::create($fields);

        // Generate the token
        // $token = $user->createToken($user->name)->plainTextToken;

        return response()->json(['user' => $user]);
    }

    public function login(Request $request)
    {
        $request->validate(([
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]));
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ['message' => "Incorrect Credentials"];
        }
        $token = $user->createToken($user->name)->plainTextToken;
        return ['user' => $user, 'token' => $token];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return ['message'=>"deleted successfully"];
    }
}
