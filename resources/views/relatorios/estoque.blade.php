@extends('layouts.app')
@section('title', 'Estoque Atual')
@section('content')
<h4 class="mb-3">Estoque Atual</h4>
<p class="text-muted">Valor total em estoque (preco compra): <strong>{{ number_format($valorTotal, 2, ',', '.') }} Kz</strong></p>
<div class="card border-0 shadow-sm">
    <table class="table mb-0"><thead class="table-light"><tr><th>Codigo</th><th>Nome</th><th>Qtd</th><th>Preco Compra</th><th>Valor</th></tr></thead>
    <tbody>@foreach($medicamentos as $m)<tr><td>{{ $m->codigo }}</td><td>{{ $m->nome_comercial }}</td><td>{{ $m->quantidade }}</td><td>{{ number_format($m->preco_compra, 2, ',', '.') }}</td><td>{{ number_format($m->quantidade * $m->preco_compra, 2, ',', '.') }} Kz</td></tr>@endforeach</tbody></table>
</div>
<a href="{{ route('relatorios.index') }}" class="btn btn-link mt-2">Voltar</a>
@endsection
