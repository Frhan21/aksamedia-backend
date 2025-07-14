<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    // Login admin
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required | string',
            'password' => 'required | string',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || Hash::check($request->password, $admin->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid username or password',
            ], 400);
        }

        $admin->tokens()->delete();

        $tokens = $admin->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login success',
            'data' => [
                'token' => $tokens,
                'admin' => [
                    'id' => $admin->id,
                    'name' => $admin->name,
                    'username' => $admin->username,
                    'phone' => $admin->phone,
                    'email' => $admin->email,
                ]
            ]
        ]);
    }

    // Logout admin
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout success',
        ]);
    }
}
