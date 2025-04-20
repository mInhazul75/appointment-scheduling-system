<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    public function register($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:host,guest'
        ]);

        if ($validator->fails()) {
            return ['error' => true, 'message' => $validator->errors()];
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);

        $token = JWTAuth::fromUser($user);

        return ['error' => false, 'data' => compact('user', 'token')];
    }

    public function login($credentials)
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            return ['error' => true, 'message' => 'Invalid credentials'];
        }

        return ['error' => false, 'data' => compact('token')];
    }

    public function me()
    {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return ['error' => true, 'message' => 'User not found'];
        }

        return ['error' => false, 'data' => compact('user')];
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return ['error' => false, 'message' => 'Successfully logged out'];
    }
}
