@extends('layouts.app')
@section('title', 'Fatura')
@section('content')
@php $config = \App\Models\Configuracao::atual(); @endphp
<div class="card border-0 shadow-sm mx-auto" style="max-width:700px">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between mb-4">
            <div><h4 class="mb-0">{{ $config->nome_farmacia }}</h4><small>{{ $config->telefone }} | {{ $config->email }}</small><br><small>{{ $config->endereco }}</small></div>
            <div class="text-end"><h5>FATURA</h5><strong>{{ $venda->numero_fatura }}</strong><br><small>{{ $venda->created_at->format('d/m/Y') }}</small></div>
        </div>
        <p><strong>Cliente:</strong> {{ $venda->cliente?->nome ?? 'Consumidor Final' }}</p>
        <table class="table table-bordered">
            <thead class="table-light"><tr><th>Codigo</th><th>Descricao</th><th>Qtd</th><th>Preco Unit.</th><th>Total</th></tr></thead>
            <tbody>
            @foreach($venda->itens as $item)
            <tr>
                <td>{{ $item->medicamento->codigo }}</td>
                <td>{{ $item->medicamento->nome_comercial }}</td>
                <td>{{ $item->quantidade }}</td>
                <td>{{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                <td>{{ number_format($item->subtotal, 2, ',', '.') }}</td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr><td colspan="4" class="text-end">Subtotal</td><td>{{ number_format($venda->subtotal, 2, ',', '.') }} Kz</td></tr>
            @if($venda->desconto > 0)<tr><td colspan="4" class="text-end">Desconto</td><td>-{{ number_format($venda->desconto, 2, ',', '.') }} Kz</td></tr>@endif
            <tr><td colspan="4" class="text-end fw-bold">Total</td><td class="fw-bold">{{ number_format($venda->total, 2, ',', '.') }} Kz</td></tr>
            </tfoot>
        </table>
        <p class="small text-muted">Forma de pagamento: {{ ucfirst($venda->forma_pagamento) }} | Vendedor: {{ $venda->user->name }}</p>
        <div class="text-center no-print mt-3">
            <button onclick="window.print()" class="btn btn-primary btn-sm">Imprimir Fatura</button>
            <a href="{{ route('vendas.historico') }}" class="btn btn-link btn-sm">Voltar</a>
        </div>
    </div>
</div>
@endsection
