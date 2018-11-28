@php
    $nome = $usuario->name;
    $saldo = $usuario->conta->saldo;
    $transacoes_debito = DB::table('transacoes')->where([
    ['conta_id', '=', $usuario->conta->conta_id],
    ['tipo_transacao', '=', 'debito']
    ])->orderBy('data_transacao')->get();

    $transacoes_credito = DB::table('transacoes')->where([
    ['conta_id', '=', $usuario->conta->conta_id],
    ['tipo_transacao', '=', 'credito']
    ])->orderBy('data_transacao')->get();

    $transacoes = $transacoes_credito->merge($transacoes_debito)->sortBy('data_transacao');;

@endphp

@extends('layouts.admin')

@section('title')
    Saldo e histórico
@endsection

@section('heading-title')
    Saldo e histórico
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12">
            <p class="saldo">
                Saldo atual: <strong><span class="font-xs">R$</span> {{ number_format($saldo,2, ',', '.') }} </strong>
            </p>
        </div>
        <div class="col-xs-12 ">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab-todos" data-toggle="tab">Todas</a>
                </li>
                <li >
                    <a  href="#tab-credito" data-toggle="tab">Crédito</a>
                </li>
                <li>
                    <a href="#tab-debito" data-toggle="tab">Débito</a>
                </li>
            </ul>
          

            <div class="tab-content ">
                <div class="tab-pane active" id="tab-todos">
                    @if($transacoes->count())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Data Mov.</th>
                                    <th>Histórico</th>
                                    <th>Valor</th>
                                    <th class="text-right">Saldo atual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transacoes as $transacao)
                                    @php
                                        if($transacao->tipo_transacao == 'debito'){ 
                                            $class='text-danger';
                                            $simbol= 'D';
                                        }else{ 
                                            $class='text-success';
                                            $simbol = 'C';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ date("d/m/Y", strtotime($transacao->data_transacao)) }}</td>
                                        <td>{{ $transacao->nome_transacao }}</td>
                                        <td class="{{ $class }} ">R$ {{ number_format($transacao->valor_transacao,2, ',', '.') }} {{ $simbol }}</td>
                                        <td class="text-right">R$ {{ number_format($transacao->saldo_atual,2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h4> Não há transações </h4>
                    @endif
                </div>
                <div class="tab-pane" id="tab-debito">
                        @if($transacoes_debito->count())
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data Mov.</th>
                                        <th>Histórico</th>
                                        <th>Valor</th>
                                        <th class="text-right">Saldo atual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transacoes_debito as $transacao)
                                        <tr>
                                            <td>{{ date("d/m/Y", strtotime($transacao->data_transacao)) }}</td>
                                            <td>{{ $transacao->nome_transacao }}</td>
                                            <td class="text-danger">R$ {{ number_format($transacao->valor_transacao,2, ',', '.') }} D</td>
                                            <td class="text-right">R$ {{ number_format($transacao->saldo_atual,2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4> Não há transações </h4>
                        @endif
                </div>
                <div class="tab-pane" id="tab-credito">
                        @if($transacoes_credito->count())
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data mov.</th>
                                        <th>Histórico</th>
                                        <th>Valor</th>
                                        <th class="text-right">Saldo atual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transacoes_credito as $transacao)
                                        <tr>
                                            <td>{{ date("d/m/Y", strtotime($transacao->data_transacao)) }}</td>
                                            <td>{{ $transacao->nome_transacao }}</td>
                                            <td class=" text-right text-success">R$ {{ number_format($transacao->valor_transacao,2, ',', '.') }} C</td>
                                            <td class=" text-right text-success">R$ {{ number_format($transacao->saldo_atual,2, ',', '.') }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h4> Não há transações </h4>
                        @endif
                </div>
            </div>
        </div>
    </div>

@endsection