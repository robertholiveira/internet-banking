<?php

namespace InternetBanking\Http\Controllers;

use InternetBanking\Transacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use InternetBanking\Conta;
use Illuminate\Support\Facades\Redirect;
Use InternetBanking\Transacao_credito;
Use InternetBanking\Transacao_debito;
class TransacaoController extends Controller
{



    /**
     * Faz uma transferencia de banco para banco
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fazer_transacao(Request $request)
    {
        $usuario_atual = auth()->user();
        $this->validate($request, [
            'cpf_favorecido' => 'required|string|max:255| exists:contas,cliente_cpf',
            'valor_transferencia' => 'required|regex:/^\d*(\,\d{1,2})?$/'
        ]);

        if($usuario_atual->cpf == $request->cpf_favorecido){
            return Redirect::back()
            ->withErrors(['cpf_favorecido'=> 'Esse é seu cpf retardado!'])
            ->withInput($request->input());
        }

        if($usuario_atual->conta->saldo < $request->valor_transferencia){
            return Redirect::back()
            ->withErrors(['valor_transferencia'=> 'Cê tem esse dinheiro todo?!'])
            ->withInput($request->input());
        }

        $this->cria_transacao_favorecido( $request->cpf_favorecido,  $request->valor_transferencia);

    }


    /**
     * Cria transacao para favorecido
     */
    protected function cria_transacao_favorecido($cpf, $valor){
        $conta = Conta::where('cliente_cpf', $cpf)->first();
        $contaAtributes = $conta->getAttributes();
      
        $transacao = new Transacao([
            'nome_transacao' => 'Transacao',
            'conta_id' => $contaAtributes['conta_id'],
            'valor_transacao' => $valor,
            'data_transacao' => date('Y-m-d')
        ]);

        $conta->transacoes()->save($transacao);
    
    }

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
