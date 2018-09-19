<?php

namespace InternetBanking\Http\Controllers;

use InternetBanking\Conta;
use Illuminate\Http\Request;
use InternetBanking\Cliente;
class ContaController extends Controller
{


 
    public static function store(Cliente $cliente)
    {
        Conta::create([
            'cliente_cpf' => $cliente->cpf,
            'saldo' => 0
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \InternetBanking\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conta $conta)
    {
        //
    }
}
