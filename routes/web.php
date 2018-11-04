<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//rota padrão para dashboard
Route::get('/home', 'HomeController@index')->name('home');

//rota da Home
Route::get('/', function () {
    return view('auth.register');
});

// Rotas de autenticação...
Route::get('login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@showLoginForm'
]);
Route::post('login', [
    'as' => '',
    'uses' => 'Auth\LoginController@login'
]);
Route::post('logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);

// Rotas de Redefinição de senha
Route::post('password/email', [
    'as' => 'password.email',
    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
    'as' => 'password.request',
    'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
    'as' => '',
    'uses' => 'Auth\ResetPasswordController@reset'
]);
Route::get('password/reset/{token}', [
    'as' => 'password.reset',
    'uses' => 'Auth\ResetPasswordController@showResetForm'
]);

// Rotas de cadastro...
Route::get('cadastro', [
    'as' => 'cadastro',
    'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('cadastro', [
    'as' => '',
    'uses' => 'Auth\RegisterController@register'
]);

//Rotas que necessitam autenticação
Route::group(['middleware' => 'auth'], function() {

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/transferencia-interna', function () {
        return view('transferencia-interna');
    })->name('transferencia-interna');

    Route::get('/transferencia-externa', function () {
        return view('transferencia-externa');
    })->name('transferencia-externa');

    Route::post('fazer-transferencia-interna', [
        'as' => 'fazer-transferencia-interna',
        'uses' => 'InternetBankingController@realizar_transferencia_interna'
    ]);

    Route::post('fazer-transferencia-externa', [
        'as' => 'fazer-transferencia-externa',
        'uses' => 'InternetBankingController@realizar_transferencia_externa'
    ]);

    Route::get('/confirma-transferencia', function () {
        
        return view('confirma-transferencia')->with();
    })->name('confirma-transferencia');

    Route::get('/saldo-historico', function () {
        $usuario = Auth::user();
        return view('saldo-historico')->with('usuario', $usuario);
    })->name('saldo-historico');
    

});


//Rotas comuns
Route::get('/logout', function(){
    return view('logout');
});

//Rota de verificação de e-mail
Route::get('/cliente/verificacaoCliente/{token}', 'Auth\RegisterController@verificarCliente');
