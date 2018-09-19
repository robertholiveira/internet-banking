@extends('layouts.website')
@section('title')
    Crie sua conta
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <p class="color-light m-b-50 text-center">Nossa conta digital é a primeira conta corrente totalmente gratuita do Brasil. Com ela, seu banco está com você a todo momento.
                <br><strong>Sem filas, sem burocracia e sem tarifas.</strong></p>
                <div class="panel p-t-30 p-r-75 p-l-75 p-b-30 panel-default" id="auth-forms">
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <div class="panel-heading text-center">
                        <h1>Abra sua conta</h1>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('cadastro') }}">
                            {{ csrf_field() }}
                            <div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="col-xs-12">
                                    <input id="name" type="text" class="form-control" placeholder="Nome" name="name" value="{{ old('name') }}" required autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class=" row form-group{{ $errors->has('cpf') ? ' has-error' : '' }} {{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-sm-6">
                                    <input id="cpf" type="text"  class="form-control cpf-field"  placeholder="CPF" name="cpf" value="{{ old('cpf') }}" required>
                                    @if ($errors->has('cpf'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cpf') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            
                                <div class="col-sm-6">
                                    <input id="email" type="email" class="form-control" placeholder="E-mail" name="email" value="{{ old('email') }}" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-sm-12">
                                    <input id="password" type="password" class="form-control" placeholder="Senha" name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>  
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12">
                                    <input id="password-confirm" type="password" class="form-control" placeholder="Confirmar senha" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-xs-12">
                                        <button type="submit" class="btn btn-primary">
                                            <span>CRIAR CONTA</span>
                                        </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
