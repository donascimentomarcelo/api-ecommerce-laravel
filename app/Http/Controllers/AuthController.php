<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Services\AuthService;

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

    public function authenticate(Request $request)
    {
        return $this->authService->authenticate($request->only('email', 'password'));
    }

}
