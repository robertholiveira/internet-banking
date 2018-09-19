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




Route::group(['middleware' => 'auth'], function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});

Route::get('/cliente/verificacaoCliente/{token}', 'Auth\RegisterController@verificarCliente');
