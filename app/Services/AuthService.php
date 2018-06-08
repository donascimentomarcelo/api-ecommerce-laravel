<?php

namespace App\Services;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = $this->jwtAuth->parseToken()->authenticate()) {
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['error' => 'Token expirado'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['error' => 'Token inválido'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['error' => 'Token ausente'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

}