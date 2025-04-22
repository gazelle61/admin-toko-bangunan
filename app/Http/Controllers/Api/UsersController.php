<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Users::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'email_verified_at',
            'phone_number' => 'required|string',
            'password' => 'required|string',
            'alamat' => 'required|text',
        ]);

        $users = Users::create($request->all());

        return response()->json($users, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $users)
    {
        return response()->json($users);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $users)
    {
        $users->update($request->all());
        return response()->json($users);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $users)
    {
        return response()->json(null, 204);
    }
}
