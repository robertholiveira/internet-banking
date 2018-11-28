@extends('layouts.admin')


@section('heading-title')
    Recarga de celular
@endsection

@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('processar-recarga') }}">
            {{ csrf_field() }}
            <div class="row form-group">
                <div class="col-sm-6">
                    <select class="form-control" name="banco" required>
                        <option value="" disabled selected>Operadora</option>
                        <option value="Caixa">Oi</option>
                        <option value="Santander">Vivo</option>
                        <option value="itaú">Tim</option>
                        <option value="Bradesco">Claro</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <input id="numero_celular" type="text" class="form-control phone-field" placeholder="Número de celular" name="numero_celular" value="{{ old('numero_celular') }}" required autofocus>
                    @if ($errors->has('numero_celular'))
                        <span class="help-block">
                            <strong>{{ $errors->first('numero_celular') }}</strong>
                        </span>
                    @endif
                    </div>    
                </div>
                <div class="col-sm-12">
                    <div class="center price-recarga">
                        <p>
                            <input type="hidden"  class="valor_recarga" name="valor_recarga">
                            <input type="checkbox" name="check15" class="c15"/>
                            <input type="checkbox" name="check30" class="c30"/>
                            <input type="checkbox" name="check50" class="c50"/>
                        </p>
                    </div>
                    @if ($errors->has('valor_recarga'))
                        <span class="help-block text-center">
                            <strong  style="position:relative; top:20px;">{{ $errors->first('valor_recarga') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group recarga-submit">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary">
                            <span>FAZER RECARGA</span>
                        </button>
                    </div>
                </div>
@endsection