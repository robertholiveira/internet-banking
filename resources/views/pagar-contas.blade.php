@extends('layouts.admin')

@section('title')
    
@endsection
@section('heading-title')
    Pague suas contas
@endsection

@section('content')
    <p class="text-center"> Pague seu boleto ou conta com facilidade e praticidade </p>
    @if (session('boleto'))
        <div class="alert alert-success">
            {{ session('boleto') }}
        </div>
    @endif
    <form class="form-horizontal" method="POST" action="{{ route('verifica-boleto') }}">
        {{ csrf_field() }}
        <div class="row form-group{{ $errors->has('linha_digitavel') ? ' has-error' : '' }}">
            <div class="col-sm-12">
                <input id="linha_digitavel" type="text" class="form-control cod-barras-field" placeholder="Código de barras do boleto ou conta" name="linha_digitavel" value="{{ old('linha_digitavel') }}" required autofocus>
                @if ($errors->has('linha_digitavel'))
                    <span class="help-block">
                        <strong>{{ $errors->first('linha_digitavel') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="row form-group{{ $errors->has('nome_beneficiario') ? ' has-error' : '' }}">
            <div class="col-sm-12">
                <input id="nome_beneficiario" type="text" class="form-control" placeholder="Nome do beneficiário" name="nome_beneficiario" value="{{ old('nome_beneficiario') }}" required autofocus>
                @if ($errors->has('nome_beneficiario'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nome_beneficiario') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary">
                        <span>PAGAR CONTA</span>
                    </button>
            </div>
        </div>
    </form>
@endsection