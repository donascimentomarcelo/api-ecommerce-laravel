<?php

namespace App\Services;
use Tymon\JWTAuth\JWTAuth;

class AuthService 
{
    /**
    * @var JWTAuth
    */
    private $jwtAuth;

    public function __construct(JWTAuth $jwtAuth)
    {
        $this->jwtAuth = $jwtAuth;
    }

    public function authenticate($credentials)
    {
        try {
            if (! $token = $this->jwtAuth->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

}