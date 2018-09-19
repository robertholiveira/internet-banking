<?php

namespace InternetBanking\Http\Controllers\Auth;

use InternetBanking\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
            return 'cpf';
    }

    public function authenticated(Request $request, $cliente)
    {
        if (!$cliente->verificado) {
            auth()->logout();
            return back()->with('warning', 'Você precisa confirmar seu e-mail para se logar.');
        }
        return redirect()->intended($this->redirectPath());
    }

    public function logout(){
        auth()->logout();
        return redirect('/login')->with('status', 'Sessão encerrada com sucesso.');
    }
}
