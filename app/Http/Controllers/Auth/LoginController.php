<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\v1\ApiController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    protected function credentials(Request $request)
    {
        return $request->only('email', 'senha');
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, 
            [
                'email'  => [
                    'required',
                    Rule::exists('usuario', 'email')->where(function ($query) use ($request){
                        $query
                            ->where('email', '=', $request->input('email'))
                            ->where('ativo', true);
                    }),
                ],
                'senha' => 'required'
            ], [],
            [                
                'email' => 'Email',
                'Senha' => 'Senha'
            ]
        );
    }

    /**
      * Handling authentication request
      *
      * @return Response
    */
    // public function authenticate(Request $request) {


    //     dd(Auth::all());

    //     return response()->json([
    //         'success' => 'false',
    //         'message' => 'Email ou senha incorreto(s)'
    //     ], ApiController::HTTP_STATUS_NOT_FOUND);

    // }
}
