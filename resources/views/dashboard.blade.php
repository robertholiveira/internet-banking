@extends('layouts.admin')

@section('title')
    
@endsection
@section('heading-title')
    Bem vindo ao Internet Banking
@endsection

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    Você está logado.

@endsection