<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\v1\ApiController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Usuario;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
      * Handling authentication request
      *
      * @return Response
    */
    public function authenticate(Request $request) {

        $usuario = Usuario::where('email', '=', $request->input('email'))->first();

        if(!$usuario) {
            return response()->json([
                'message' => 'O respectivo email não foi encontrado'
            ], ApiController::HTTP_STATUS_NOT_FOUND);
        }

        if(Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('senha'), 'ativo' => true])) {
            return response()->json([
                'success' => 'true',
                'url' => '/dashboard'
            ], ApiController::HTTP_STATUS_SUCCESS);    
        }

        return response()->json([
            'success' => 'false',
            'message' => 'Email ou senha incorreto(s)'
        ], ApiController::HTTP_STATUS_NOT_FOUND);

    }
}
