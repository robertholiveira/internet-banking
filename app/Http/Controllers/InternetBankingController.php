<?php

namespace InternetBanking\Http\Controllers;

use Illuminate\Http\Request;
use InternetBanking\Http\Controllers\TransacaoController;
use InternetBanking\Conta;
use InternetBanking\Cliente;
use Illuminate\Support\Facades\Redirect;

class InternetBankingController extends Controller
{
     /**
     * Faz uma transferencia de banco para banco
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function realizar_transferencia_interna(Request $request)
    {
        
        $usuario_atual = auth()->user();
        $usuario_favorecido = Cliente::find($request->cpf_favorecido);
        $valor_transferencia = $request->valor_transferencia; 

        $this->validate($request, [
            'cpf_favorecido' => 'required|string|max:255|exists:contas,cliente_cpf',
            'valor_transferencia' => 'required|regex:/^\d*(\.\d{1,2})?$/'
        ]);

        if($usuario_atual->cpf == $usuario_favorecido->cpf){
            return Redirect::back()
            ->withErrors(['cpf_favorecido'=> 'CPF favorecido deve ser diferente ao de sua conta.'])
            ->withInput($request->input());
        }

        if($usuario_atual->conta->saldo < $valor_transferencia){
            return Redirect::back()
            ->withErrors(['valor_transferencia'=> 'Saldo insuficiente para realizar transação.'])
            ->withInput($request->input());
        }

        TransacaoController::lanca_debito( $usuario_atual, 'Transferência para '.$usuario_favorecido->name, $valor_transferencia);
        TransacaoController::lanca_credito( $usuario_favorecido, 'Transferência de '.$usuario_atual->name, $valor_transferencia);

        return redirect::back()->with('sucess', "Transferência efetuada com sucesso.");
    }

     /**
     * Faz uma transferencia de banco para outro banco
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function realizar_transferencia_externa(Request $request)
    {
        $usuario_atual = auth()->user();
        $valor_transferencia = $request->valor_transferencia_externo; 
        $nome_favorecido = $request->nome_favorecido; 

        $this->validate($request, [
            'cpf_favorecido_externo' => 'required|string|max:255',
            'valor_transferencia_externo' => 'required|regex:/^\d*(\.\d{1,2})?$/'
        ]);

        if($usuario_atual->conta->saldo < $valor_transferencia){
            return Redirect::back()
            ->withErrors(['valor_transferencia_externo'=> 'Saldo insuficiente para realizar transação.'])
            ->withInput($request->input());
        }

        TransacaoController::lanca_debito( $usuario_atual, 'Transferência para '.$nome_favorecido, $valor_transferencia);

        return redirect::back()->with('sucess', "Transferência efetuada com sucesso.");
    }

}
