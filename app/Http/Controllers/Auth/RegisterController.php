<?php

namespace InternetBanking\Http\Controllers\Auth;

use InternetBanking\Cliente;
use InternetBanking\VerificarCliente;
use InternetBanking\Mail\VerificacaoEmail;
use InternetBanking\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use InternetBanking\Notifications\VerificacaoDeCliente;
use InternetBanking\Http\Controllers\ContaController;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [

            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:255|unique:clientes',
            'email' => 'required|string|email|max:255|unique:clientes',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Horsefly\User
     */
    protected function create(array $data)
    {

        $cliente = Cliente::create([
            'cpf' => $data['cpf'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verificado' => 0,
        ]);
 
        // insere no banco de dados token de verificação de e-mail
        $verificarCliente = VerificarCliente::create([
            'cliente_cpf' => $cliente->cpf,
            'token' => str_random(40)
        ]);
 
        //Mail::to($cliente->email)->send(new VerificacaoEmail($cliente));
        $cliente->notify(new VerificacaoDeCliente($cliente));
 
        return $cliente;
    }

    public function verificarCliente($token)
    {
        $verificacaoCliente = VerificarCliente::where('token', $token)->first();
        if(isset($verificacaoCliente ) ){
            $cliente =  $verificacaoCliente->cliente;
            if(!$cliente->verificado) {
                $verificacaoCliente->cliente->verificado = 1;
                $verificacaoCliente->cliente->save();
                
                ContaController::store($verificacaoCliente->cliente);

                $status = "Seu e-mail foi verificado, agora poderá fazer login.";
            }else{
                $status = "Seu e-mail já está verificado.";
            }
        }else{
            return redirect('/login')->with('warning', "Desculpe, seu e-mail não pode ser verificado.");
        }
        
        return redirect('/login')->with('status', $status);
    }

    protected function registered(Request $request, $cliente)
    {
        $this->guard()->logout();
        return redirect('/login')->with('status', 'Nós enviamos um código de verificação em seu e-mail. Por favor, verifique.');
    }


 
}


