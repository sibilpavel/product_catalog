<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where(
            'email',
            $request->email
        )->first();

        if (! $user || ! Hash::check(
                $request->password,
                $user->password
            )) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user
            ->createToken('admin-token')
            ->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
