@extends('layouts.app')
@section('title', 'Historico de Vendas')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Historico de Vendas</h4>
    <a href="{{ route('vendas.pdv') }}" class="btn btn-primary btn-sm">Nova Venda</a>
</div>
<form class="mb-3" method="GET">
    <div class="input-group" style="max-width:300px">
        <input type="date" name="data" class="form-control" value="{{ request('data') }}">
        <button class="btn btn-outline-secondary">Filtrar</button>
    </div>
</form>
<div class="card border-0 shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Fatura</th><th>Data</th><th>Cliente</th><th>Total</th><th>Pagamento</th><th>Vendedor</th><th></th></tr></thead>
        <tbody>
        @foreach($vendas as $v)
        <tr>
            <td>{{ $v->numero_fatura }}</td>
            <td>{{ $v->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $v->cliente?->nome ?? 'Consumidor Final' }}</td>
            <td>{{ number_format($v->total, 2, ',', '.') }} Kz</td>
            <td>{{ ucfirst($v->forma_pagamento) }}</td>
            <td>{{ $v->user->name }}</td>
            <td class="text-end">
                <a href="{{ route('vendas.recibo', $v) }}" class="btn btn-sm btn-outline-secondary">Recibo</a>
                <a href="{{ route('vendas.fatura', $v) }}" class="btn btn-sm btn-outline-primary">Fatura</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $vendas->links() }}
@endsection
