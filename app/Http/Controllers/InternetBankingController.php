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
        $valor_transferencia = str_replace(",", ".",  str_replace(".","", $request->valor_transferencia));
        

        $this->validate($request, [
            'cpf_favorecido' => 'required|string|max:255|exists:contas,cliente_cpf',
            'valor_transferencia' => 'required'
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
        $valor_transferencia = str_replace(",", ".",  str_replace(".","", $request->valor_transferencia_externo));
        $nome_favorecido = $request->nome_favorecido; 

        $this->validate($request, [
            'cpf_favorecido_externo' => 'required|string|max:255',
            'valor_transferencia_externo' => 'required|'
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

        if($usuario_atual->conta->saldo < $valor_boleto){
            return redirect::route('pagar-contas')->with('warning', "Saldo insuficiente para realizar operação.");
        }

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
            ->with(['valor_recarga'=> 'O campo valor recarga é obrigatório.']);
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
    
        $this->getAPI("POST", "https://www.garlicsms.com/api/send", $data);

    }

    function get_conversoes(){
        $respUSD = $this->getAPI("GET", "https://free.currencyconverterapi.com/api/v6/convert?q=USD_BRL&compact=ultra", false );
        $respEUR = $this->getAPI("GET", "https://free.currencyconverterapi.com/api/v6/convert?q=EUR_BRL&compact=ultra", false );
        $respJPY = $this->getAPI("GET", "https://free.currencyconverterapi.com/api/v6/convert?q=JPY_BRL&compact=ultra", false );   
        $respGBP = $this->getAPI("GET", "https://free.currencyconverterapi.com/api/v6/convert?q=GBP_BRL&compact=ultra", false );   
        $respCAD = $this->getAPI("GET", "https://free.currencyconverterapi.com/api/v6/convert?q=CAD_BRL&compact=ultra", false );   
        $respAUD = $this->getAPI("GET", "https://free.currencyconverterapi.com/api/v6/convert?q=AUD_BRL&compact=ultra", false );   
        $respARS = $this->getAPI("GET", "https://free.currencyconverterapi.com/api/v6/convert?q=ARS_BRL&compact=ultra", false );   
        $respCHF = $this->getAPI("GET", "https://free.currencyconverterapi.com/api/v6/convert?q=CHF_BRL&compact=ultra", false ); 
        $respNZD = $this->getAPI("GET", "https://free.currencyconverterapi.com/api/v6/convert?q=NZD_BRL&compact=ultra", false );                     
        $respBTC = $this->getAPI("GET", "https://free.currencyconverterapi.com/api/v6/convert?q=BTC_BRL&compact=ultra", false );   


        $conversoes = array(
            'usd' => reset($respUSD),
            'eur' => reset($respEUR),
            'jpy' => reset($respJPY),
            'gbp' => reset($respGBP),
            'cad' => reset($respCAD),
            'aud' => reset($respAUD),
            'ars' => reset($respARS),
            'chf' => reset($respCHF),
            'nzd' => reset($respNZD),        
            'btc' => reset($respBTC),
        );

        return view('conversoes')->with('conversoes', $conversoes);
    }

    public function getAPI($method, $url, $data){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json",
            ),
            CURLOPT_URL => $url
        ));

        if($method == "POST"){
            curl_setopt($curl,  CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl,  CURLOPT_POSTFIELDS, json_encode($data));
        }

         // Send the request & save response to $resp
         $resp = curl_exec($curl);
         $err = curl_error($curl);
    
         curl_close($curl);
         
         return json_decode($resp, true);

    }

}
