
@extends('layouts.admin')

@section('title')
    
@endsection
@section('heading-title')
    Confirmação de boleto
@endsection

@section('content')
<p>Beneficiário: {{ $boleto['beneficiario']}}</p>
<p>Valor do boleto: <b>R$ {{ $boleto['valor']}}</b></p>
<p>Linha digitável: {{ $boleto['codigo']}}</p>
<form class="form-horizontal" method="POST" action="{{ route('processa-boleto') }}">
    {{ csrf_field() }}
    <input id="linha_digitavel" type="hidden" name="linha_digitavel" value="{{ $boleto['codigo'] }}" required autofocus>
    <input id="beneficiario" type="hidden" name="beneficiario" value="{{ $boleto['beneficiario'] }}" required autofocus>

    <div class="form-group">
        <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">
                    <span>CONFIRMAR PAGAMENTO</span>
                </button>
        </div>
    </div>
</form>
@endsection