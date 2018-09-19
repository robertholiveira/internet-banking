@extends('layouts.website')

@section('title')
    Entre na sua conta
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel p-t-30 p-r-75 p-l-75 p-b-30 panel-default">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert alert-warning">
                        {{ session('warning') }}
                    </div>
                @endif

                <div class="panel-heading text-center">
                    <h1>Entre na sua conta</h1>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}" id="auth-forms">
                        {{ csrf_field() }}

                        <div class="row form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <input id="cpf" type="text" class="form-control" name="cpf" placeholder="CPF" value="{{ old('cpf') }}" required autofocus>

                                @if ($errors->has('cpf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cpf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Senha"  required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <span>ENTRAR</span>
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Esqueceu sua senha?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
