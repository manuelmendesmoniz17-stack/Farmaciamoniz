@extends('layouts.app')
@section('title', 'Proximos da Validade')
@section('content')
<h4 class="mb-3 text-warning">Produtos Proximos da Validade (30 dias)</h4>
<div class="card border-0 shadow-sm">
    <table class="table mb-0"><thead class="table-light"><tr><th>Codigo</th><th>Nome</th><th>Validade</th><th>Qtd</th></tr></thead>
    <tbody>@forelse($medicamentos as $m)<tr><td>{{ $m->codigo }}</td><td>{{ $m->nome_comercial }}</td><td>{{ $m->data_validade->format('d/m/Y') }}</td><td>{{ $m->quantidade }}</td></tr>@empty<tr><td colspan="4" class="text-muted">Nenhum produto</td></tr>@endforelse</tbody></table>
</div>
<a href="{{ route('relatorios.index') }}" class="btn btn-link mt-2">Voltar</a>
@endsection
