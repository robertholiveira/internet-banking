<?php


namespace InternetBanking\Http\Controllers;

use Illuminate\Http\Request;
use InternetBanking\Http\Controllers\TransacaoController;
use InternetBanking\Conta;
use InternetBanking\Cliente;
use Illuminate\Support\Facades\Redirect;
use InternetBanking\Libraries\boletosPHP;

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

    public function verifica_boleto(Request $request){
        $codigo_boleto = $request->linha_digitavel;
        $beneficiario = $request->nome_beneficiario;
        $boleto = new boletosPHP();
        $boleto->setIpte($codigo_boleto);
        
        $data_boleto = array(
            'codigo' => $boleto->getIpte(),
            'valor' => $boleto->getValorDocumento(),
            'data_venc' => $boleto -> getDtVencimento("d/m/Y"),
            'beneficiario' => $beneficiario,
        );
        return view('confirma-boleto')->with('boleto', $data_boleto);
        
    }

    public function processa_boleto(Request $request){
        $usuario_atual = auth()->user();
        $codigo_boleto = $request->linha_digitavel;
        $beneficiario = $request->beneficiario;
        $boleto = new boletosPHP();
        $boleto->setIpte($codigo_boleto);
        $valor_boleto = (double)$boleto->getValorDocumento();
        TransacaoController::lanca_debito( $usuario_atual, 'Pagamento de boleto para '.$beneficiario, $valor_boleto);

        return redirect::route('pagar-contas')->with('sucess', "Pag. de boleto efetuado com sucesso.");
    }

    public function realiza_recarga(Request $request){

        $this->validate($request, [
            'numero_celular' => 'required|string|max:20',
            'valor_recarga' => 'required'
        ]);

        if(!isset($_POST['check15']) and !isset($_POST['check30']) and !isset($_POST['check50']) ){
            return Redirect::back()
            ->withErrors(['valor_recarga'=> 'O campo valor recarga é obrigatório.'])
            ->withInput($request->input());
        }

        $usuario_atual = auth()->user();

        $numero_recarga = $request->numero_celular;
        $valor ="";
        if(isset($_POST['check15'])){
            $valor = 15;
        }
        if(isset($_POST['check30'])){
            $valor = 30;
        }
        if(isset($_POST['check50'])){
            $valor = 50;
        }

        if($usuario_atual->conta->saldo < $valor){
            return Redirect::back()
            ->withErrors(['valor_recarga'=> 'Saldo insuficiente para realizar transação.'])
            ->withInput($request->input());
        }

        TransacaoController::lanca_debito( $usuario_atual, "Recarga: Número ".$numero_recarga, $valor);

        $message = "Celular recarregado com sucesso! Você recarregou R$".$valor.",00 reais.";
        $numero_tratado = preg_replace('/[^0-9]/', '', $numero_recarga);
        $this->envia_sms($message , $numero_tratado); 

        return redirect::back()->with('sucess', "Recarga efetuada com sucesso.");
       
    }

    public function envia_sms($message, $destination_number){
        $data = [
            'key' => '$2y$10$.jixh0z4oCCGIitxfXx3ju3H7FJyTVfLlklCxCAp8HtNuqjQpUqEG',
            "title"=> "Recarga de celular MineCash",
            "message" => $message,
            "destination_number" => $destination_number
        ];
        
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.garlicsms.com/api/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
    }


}
