<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    // public function register(Request $request)
    // {
    //     $data = $request->validate([

    //     ]);

    //     $users = Admin::create([

    //     ]);

    //     $token = $users->createToken('BE Token')->plainTextToken;

    //     return response()->json([
    //         'users' => $users,
    //         'token' => $token,
    //     ], 201);
    // }

    // public function login(Request $request)
    // {
    //     $data = $request->validate([

    //     ]);

    //     $users = Admin::where(, $data[''])->first();

    //     if(! $users || Hash::check($data[], $users->password)) {
    //         throw ValidationException::withMessages([
    //             '' => [''],
    //         ]);
    //     }

    //     $users->tokens()->where('name', 'BE Token')->delete();

    //     $token = $users->createToken('BE Token')->plainTextToken;

    //     return response()->json([
    //         'users'  => $users,
    //         'token' => $token,
    //     ]);
    // }

    // public function logout(Request $request)
    // {

    // }
}
