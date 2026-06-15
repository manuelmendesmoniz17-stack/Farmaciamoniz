@extends('layouts.app')
@section('title', 'Vendas Mensais')
@section('content')
<h4 class="mb-3">Vendas Mensais</h4>
<form class="mb-3" method="GET"><input type="month" name="mes" class="form-control d-inline-block" style="width:auto" value="{{ $mes }}"><button class="btn btn-primary">Filtrar</button></form>
<p class="fw-bold">Total do Mes: {{ number_format($totalMes, 2, ',', '.') }} Kz</p>
<div class="card border-0 shadow-sm">
    <table class="table mb-0"><thead class="table-light"><tr><th>Dia</th><th>Qtd Vendas</th><th>Total</th></tr></thead>
    <tbody>@foreach($vendas as $v)<tr><td>{{ $v->dia }}</td><td>{{ $v->qtd }}</td><td>{{ number_format($v->total, 2, ',', '.') }} Kz</td></tr>@endforeach</tbody></table>
</div>
<a href="{{ route('relatorios.index') }}" class="btn btn-link mt-2">Voltar</a>
@endsection
