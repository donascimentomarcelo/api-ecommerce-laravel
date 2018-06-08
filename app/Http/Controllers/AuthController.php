<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Return a valid token to user authenticated
     *
     * @param Request $request
     * @return void
     */
    public function authenticate(AuthRequest $request)
    {
        return $this->authService->authenticate($request->only('email', 'password'));
    }

    /**
     * Return a refreshed valid token
     *
     * @return void
     */
    public function refreshToken()
    {
        return $this->authService->refreshToken();
    }

    /**
     * Destroy the token authenticated
     *
     * @return void
     */
    public function logout()
    {
        return $this->authService->logout();
    }

    /**
     * Get the user data logged
     *
     * @return void
     */
    public function getAuthenticatedUser()
    {
        return $this->authService->getAuthenticatedUser();
    }
}
