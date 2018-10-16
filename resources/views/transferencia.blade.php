@extends('layouts.admin')

@section('title')
    
@endsection
@section('heading-title')
    Faça uma transferência
@endsection

@section('content')
<pre>
<?php var_dump($errors) ?>
</pre>
    <form class="form-horizontal" method="POST" action="{{ route('fazer-transferencia') }}">
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
                <input id="valor_transferencia" type="text" class="form-control" placeholder="Valor da transferência" name="valor_transferencia" value="{{ old('valor_transferencia') }}" required>
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

@endsection