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
                <li class="active">
                    <a  href="{{ route('transferencia-interna') }}" >Minecash</a>
                </li>
                <li>
                    <a href="{{ route('transferencia-externa') }}" >Outros bancos</a>
                </li>
            </ul>
        

            <div class="tab-content">
                <div class="tab-pane active" id="tab-interna">
                    <form class="form-horizontal" method="POST" action="{{ route('fazer-transferencia-interna') }}">
                        {{ csrf_field() }}
                        <div class="row form-group{{ $errors->has('cpf_favorecido') ? ' has-error' : '' }}">
                            <div class="col-sm-6">
                                <input id="cpf_favorecido" type="text" class="form-control cpf-field" placeholder="CPF do titular da conta" name="cpf_favorecido" value="{{ old('cpf_favorecido') }}" required autofocus>
                                @if ($errors->has('cpf_favorecido'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cpf_favorecido') }}</strong>
                                    </span>
                                @endif
                            </div>
                
                            <div class="col-sm-6">
                                <div class="input-group prefix">                           
                                    <span class="input-group-addon">R$</span>
                                    <input id="valor_transferencia" type="text" class="money-field form-control" placeholder="Valor da transferência" name="valor_transferencia" value="{{ old('valor_transferencia') }}" required>
                                </div>
                                @if ($errors->has('valor_transferencia'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor_transferencia') }}</strong>
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
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection