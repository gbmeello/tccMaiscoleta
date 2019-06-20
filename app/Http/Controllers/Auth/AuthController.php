<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    // Autenticação padrão, porém com o JWT.
    public function login(Request $request) {

        $credentials = $request->only(['email', 'senha']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }

        return response()->json([
            'status' => 'success',
            'token' => $token
        ]);
    }

    // Renovação de Token
    public function refresh() {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);
        return response()->json([
            'token' => $newToken
        ]);
    }

    // Retorna as informações da sessão atual
    public function me() {
        return response()->json(Auth::user());
    }

    // Invalida a sessão atual
    public function logout() {
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);
        return response()->json([
            'status' => 'success'
        ]);
    }
}
