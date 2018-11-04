<?php

namespace InternetBanking\Http\Controllers;

use InternetBanking\Transacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use InternetBanking\Transacao_credito;
Use InternetBanking\Transacao_debito;
class TransacaoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lança crédito para um usuário
     */
    public static function lanca_credito($usuario, $nome_transacao , $valor){

        //retira valor de conta
        $usuario->conta->saldo +=$valor;

        $transacao = new Transacao_credito([
            'nome_transacao' => $nome_transacao,
            'valor_transacao' => $valor,
            'data_transacao' => date('Y-m-d H:i:s'),
            'saldo_atual' => $usuario->conta->saldo
        ]);

        $usuario->conta->transacoes()->save($transacao);
        
        $usuario->conta->save();
    }

    /**
     * Lança débito para um usuário
     */
    public static function lanca_debito($usuario, $nome_transacao, $valor){

        $usuario->conta->saldo -= $valor;
        
        $transacao = new Transacao_debito([
            'nome_transacao' => $nome_transacao,
            'valor_transacao' => $valor,
            'data_transacao' => date('Y-m-d H:i:s'),
            'saldo_atual' => $usuario->conta->saldo
        ]);
        $usuario->conta->transacoes()->save($transacao);
        $usuario->conta->save();
    }

    

    /* ====== Padrão Laravel ======== */

    /**
     * Display the specified resource.
     *
     * @param  \InternetBanking\Transacao  $transacao
     * @return \Illuminate\Http\Response
     */
    public function show(Transacao $transacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \InternetBanking\Transacao  $transacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Transacao $transacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \InternetBanking\Transacao  $transacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transacao $transacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \InternetBanking\Transacao  $transacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transacao $transacao)
    {
        //
    }
}
