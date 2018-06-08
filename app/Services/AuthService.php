<?php

namespace App\Services;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

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
                return response()->json(['error' => 'Credenciais inválidas'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'O token não pode ser criado'], 500);
        }

        return response()->json(compact('token'));
    }

    public function refreshToken()
    {
        $token = $this->jwtAuth->getToken();
        if(!$token)
        {
            return response()->json(['error' => 'Acesso negado'], 401);
        }
        try{
            $token = $this->jwtAuth->refresh($token);
        }catch(JWTException $e){
            return response()->json(['error' => 'O token não pode ser criado'], 500);
        }

        return response()->json(compact('token'));
    }

    public function logout()
    {
        $token = $this->jwtAuth->getToken();
        if(!$token)
        {
            return response()->json(['error' => 'Acesso negado'], 401);
        }
        try{
            $this->jwtAuth->invalidate($token);
        }catch(JWTException $e){
            return response()->json(['error' => 'Erro ao realizar logout'], 500);
        }

        return response()->json(['message' => 'Logout realizado'], 200);
    }

}