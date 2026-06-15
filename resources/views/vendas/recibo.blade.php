@extends('layouts.app')
@section('title', 'Recibo')
@section('content')
@php $config = \App\Models\Configuracao::atual(); @endphp
<div class="card border-0 shadow-sm mx-auto" style="max-width:500px">
    <div class="card-body p-4">
        <div class="text-center mb-3">
            <h5 class="mb-0">{{ $config->nome_farmacia }}</h5>
            <small class="text-muted">{{ $config->endereco }}</small>
        </div>
        <hr>
        <p class="mb-1"><strong>Recibo:</strong> {{ $venda->numero_fatura }}</p>
        <p class="mb-1"><strong>Data:</strong> {{ $venda->created_at->format('d/m/Y H:i') }}</p>
        <p class="mb-3"><strong>Cliente:</strong> {{ $venda->cliente?->nome ?? 'Consumidor Final' }}</p>
        <table class="table table-sm">
            <thead><tr><th>Item</th><th>Qtd</th><th>Total</th></tr></thead>
            <tbody>
            @foreach($venda->itens as $item)
            <tr><td>{{ $item->medicamento->nome_comercial }}</td><td>{{ $item->quantidade }}</td><td>{{ number_format($item->subtotal, 2, ',', '.') }}</td></tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-end">
            <p class="mb-0">Subtotal: {{ number_format($venda->subtotal, 2, ',', '.') }} Kz</p>
            @if($venda->desconto > 0)<p class="mb-0">Desconto: -{{ number_format($venda->desconto, 2, ',', '.') }} Kz</p>@endif
            <p class="fs-5 fw-bold">Total: {{ number_format($venda->total, 2, ',', '.') }} Kz</p>
            <small>Pagamento: {{ ucfirst($venda->forma_pagamento) }}</small>
        </div>
        <div class="text-center mt-3 no-print">
            <button onclick="window.print()" class="btn btn-primary btn-sm">Imprimir</button>
            <a href="{{ route('vendas.pdv') }}" class="btn btn-success btn-sm">Nova Venda</a>
            <a href="{{ route('vendas.historico') }}" class="btn btn-link btn-sm">Historico</a>
        </div>
    </div>
</div>
@endsection
