<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Usuario;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Get the password reset validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'senha' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ];
    }


    public function reset(Request $request)
    {
        $request->validate($this->rules(), $this->validationErrorMessages());

        $credentials = $this->credentials($request);

        $usuario = Usuario::where('email', '=', $credentials['email'])->first();
        if($usuario) {
            $reset_token = strtolower(str_random(64));

            $usuario->senha = $credentials['senha'];
            $usuario->save();

            DB::table('password_resets')->insert([
                'email' => $credentials['email'],
                'token' => $reset_token,
                'created_at' => Carbon::now(),
            ]);

            return redirect()->back()->with('status', 'Sucesso');

        } else {
            return redirect()->back()->with('status', 'O Email não consta no banco de dados');
        }
    }


    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'senha', 'password_confirmation', 'token'
        );
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
