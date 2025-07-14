<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

/**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Login Admin",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"username","password"},
 *             @OA\Property(property="username", type="string", example="admin"),
 *             @OA\Property(property="password", type="string", example="pastibisa")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful Login",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Login successful"),
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="token", type="string"),
 *                 @OA\Property(property="admin", type="object",
 *                     @OA\Property(property="id", type="string"),
 *                     @OA\Property(property="name", type="string"),
 *                     @OA\Property(property="username", type="string"),
 *                     @OA\Property(property="phone", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                 )
 *             )
 *         )
 *     )
 * )
 *
 * * @OA\Post(
 *     path="/api/logout",
 *     summary="Logout Admin",
 *     tags={"Authentication"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="Successful Logout",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string", example="success"),
 *             @OA\Property(property="message", type="string", example="Logout successful")
 *         )
 *     )
 * )
 */


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
