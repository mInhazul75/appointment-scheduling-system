<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Helpers\ResponseHelper;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $result = $this->authService->register($request->all());

        if ($result['error']) {
            return ResponseHelper::error('Validation failed', 422, $result['message']);
        }

        return ResponseHelper::success($result['data'], 'User registered successfully', 201);
    }

    public function login(Request $request)
    {
        try {
            $result = $this->authService->login($request->only('email', 'password'));

            if ($result['error']) {
                return ResponseHelper::error($result['message'], 401);
            }

            return ResponseHelper::success($result['data'], 'Login successful');
        } catch (JWTException $e) {
            return ResponseHelper::error('Could not create token', 500);
        }
    }

    public function me()
    {
        try {
            $result = $this->authService->me();

            if ($result['error']) {
                return ResponseHelper::error($result['message'], 404);
            }

            return ResponseHelper::success($result['data']);
        } catch (JWTException $e) {
            return ResponseHelper::error('Token error', 401);
        }
    }

    public function logout()
    {
        try {
            $result = $this->authService->logout();

            return ResponseHelper::success([], $result['message']);
        } catch (JWTException $e) {
            return ResponseHelper::error('Failed to logout, please try again.', 500);
        }
    }
}
