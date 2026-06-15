@extends('layouts.app')
@section('title', 'Vendas Diarias')
@section('content')
<h4 class="mb-3">Vendas Diarias</h4>
<form class="mb-3" method="GET"><input type="date" name="data" class="form-control d-inline-block" style="width:auto" value="{{ $data }}"><button class="btn btn-primary">Filtrar</button></form>
<div class="card border-0 shadow-sm">
    <table class="table mb-0"><thead class="table-light"><tr><th>Fatura</th><th>Hora</th><th>Cliente</th><th>Total</th></tr></thead>
    <tbody>@foreach($vendas as $v)<tr><td>{{ $v->numero_fatura }}</td><td>{{ $v->created_at->format('H:i') }}</td><td>{{ $v->cliente?->nome ?? '-' }}</td><td>{{ number_format($v->total, 2, ',', '.') }} Kz</td></tr>@endforeach</tbody>
    <tfoot><tr class="fw-bold"><td colspan="3">Total do Dia</td><td>{{ number_format($total, 2, ',', '.') }} Kz</td></tr></tfoot></table>
</div>
<a href="{{ route('relatorios.index') }}" class="btn btn-link mt-2">Voltar</a>
@endsection
