<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function getUser(Request $request)
    {
        try {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Berhasil mendapatkan data user!',
                    'data' => new UserResource($request->user()),
                ],
                200,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Email atau password salah!',
                    ],
                    401,
                );
            }

            $user = Auth::user();
            $token = $user->createToken('auth:token')->plainTextToken;

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Login Berhasil!',
                    'data' => new UserResource($user),
                    'token' => $token,
                ],
                200,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Logout Berhasil!',
                ],
                200,
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $th->getMessage(),
                ],
                500,
            );
        }
    }
}
