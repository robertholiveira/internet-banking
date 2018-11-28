@extends('layouts.admin')

@section('title')
    
@endsection
@section('heading-title')
    Faça uma transferência
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12 ">
            <ul class="nav nav-tabs">
                <li>
                    <a  href="{{ route('transferencia-interna') }}" >Minecash</a>
                </li>
                <li  class="active">
                    <a href="{{ route('transferencia-externa') }}" >Outros bancos</a>
                </li>
            </ul>

                <form class="form-horizontal" method="POST" action="{{ route('fazer-transferencia-externa') }}">
                    {{ csrf_field() }}
                    <div class="row form-group">
                        <div class="col-sm-5">
                            <select class="form-control" name="banco" required>
                                <option value="" disabled selected>Escolha o banco</option>
                                <option value="Caixa">Caixa</option>
                                <option value="Santander">Santander</option>
                                <option value="itaú">Itaú</option>
                                <option value="Bradesco">Bradesco</option>
                                <option value="Inter">Inter</option>
                            </select>
                        </div>

                        <div class="col-sm-3">
                            <input type="text" pattern="[0-9]{4}" class="form-control agencia-field" placeholder="Agência" name="agencia" required autofocus>
                        </div>

                        <div class="col-sm-4">
                            <input type="text" class="form-control conta-field" placeholder="Conta" name="conta" required autofocus>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-4">
                            <input id="cpf_favorecido_externo" type="text" class="form-control cpf-field" placeholder="CPF do titular da conta" name="cpf_favorecido_externo" value="{{ old('cpf_favorecido') }}" required autofocus>
                            @if ($errors->has('cpf_favorecido_externo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('cpf_favorecido_externo') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Nome do favorecido" name="nome_favorecido" required autofocus>
                        </div>

                        
                        <div class="col-sm-4">
                            <div class="input-group prefix">                           
                                <span class="input-group-addon">R$</span>
                                <input id="valor_transferencia_externo" type="text" class="money-field form-control" placeholder="Valor da transferência" name="valor_transferencia_externo" value="{{ old('valor_transferencia') }}" required>
                            </div>
                            @if ($errors->has('valor_transferencia_externo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('valor_transferencia_externo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary">
                                <span>FAZER TRANSFERÊNCIA</span>
                            </button>
                        </div>
                    </div>
                </div>
                
            </form>

        </div>
    </div>

@endsection