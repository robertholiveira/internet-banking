@php
  
@endphp

@extends('layouts.admin')


@section('heading-title')
    Cotações
@endsection

@section('content')
    <div class="row conversoes">
        <div class="col-sm-12 card-coin bitcoin no-border">
            <strong>BTC: Bitcoin</strong>
            <p>R$ {{ number_format($conversoes['btc'],4, ',', '.') }}</p>
        </div>
        <div class="col-sm-4 card-coin">
            <h4>USD: Dólar Americano</h4>
            <p>R$ {{ number_format($conversoes['usd'],4, ',', '.') }}</p>
        </div>
        <div class="col-sm-4 card-coin">
            <h4>EUR: Euro</h4>
            <p>R$ {{ number_format($conversoes['eur'],4, ',', '.') }}</p>
        </div>
        <div class="col-sm-4 card-coin">
            <h4>JPY: Yen Japonês</h4>
            <p>R$ {{ number_format($conversoes['jpy'],4, ',', '.') }}</p>
        </div>

        <div class="col-sm-4 card-coin">
            <h4>ARS: Peso Argentino</h4>
            <p>R$ {{ number_format($conversoes['ars'],4, ',', '.') }}</p>
        </div>
        <div class="col-sm-4 card-coin">
            <h4>CHF: Franco Suíço</h4>
            <p>R$ {{ number_format($conversoes['chf'],4, ',', '.') }}</p>
        </div>
        <div class="col-sm-4 card-coin">
            <h4>NZD: Dólar Neozelandês </h4>
            <p>R$ {{ number_format($conversoes['nzd'],4, ',', '.') }}</p>
        </div>

        <div class="col-sm-4 card-coin no-border">
            <h4>GBP: Libra Esterlina</h4>
            <p>R$ {{ number_format($conversoes['gbp'],4, ',', '.') }}</p>
        </div>
        <div class="col-sm-4 card-coin no-border">
            <h4>CAD: Dólar Canadense</h4>
            <p>R$ {{ number_format($conversoes['cad'],4, ',', '.') }}</p>
        </div>
        <div class="col-sm-4 card-coin no-border">
            <h4>AUD: Dólar Australiano</h4>
            <p>R$ {{ number_format($conversoes['aud'],4, ',', '.') }}</p>
        </div> 
    </div>
@endsection