@extends('layouts.admin')

@section('title')
    
@endsection
@section('heading-title')
    Encerrar sessão
@endsection

@section('content')
    <p>Deseja realmente encerrar a sessão? Fazendo isso não será possível acessar sua conta enquanto não digitar os dados de Login novamente.</p>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
            {{ csrf_field() }}
            <a class="btn btn-primary" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                Encerrar sessão
            </a>
    </form>

@endsection