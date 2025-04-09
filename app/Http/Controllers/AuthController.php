<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function login(Request $requset)
    {
        $requset->validate([
            'login' => 'required|string', //Ini bisa pake email atau nomor hp
            'password' => 'required|string',
        ]);

        $user = User::where('email', $requset->login)
                    ->orWhere('phone', $requset->login)
                    ->first();

        if (!$user || !Hash::check($requset->password, $user->password)) {
            throw ValidationException::withMessages(['login' => 'Invalid credentials']);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $requset)
    {
        $requset()->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
