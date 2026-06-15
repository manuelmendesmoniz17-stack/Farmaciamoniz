@extends('layouts.app')
@section('title', 'Produtos Vencidos')
@section('content')
<h4 class="mb-3 text-danger">Produtos Vencidos</h4>
<div class="card border-0 shadow-sm">
    <table class="table mb-0"><thead class="table-light"><tr><th>Codigo</th><th>Nome</th><th>Lote</th><th>Validade</th><th>Qtd</th></tr></thead>
    <tbody>@forelse($medicamentos as $m)<tr><td>{{ $m->codigo }}</td><td>{{ $m->nome_comercial }}</td><td>{{ $m->lote }}</td><td class="text-danger">{{ $m->data_validade->format('d/m/Y') }}</td><td>{{ $m->quantidade }}</td></tr>@empty<tr><td colspan="5" class="text-muted">Nenhum produto vencido</td></tr>@endforelse</tbody></table>
</div>
<a href="{{ route('relatorios.index') }}" class="btn btn-link mt-2">Voltar</a>
@endsection
