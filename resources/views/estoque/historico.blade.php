@extends('layouts.app')
@section('title', 'Historico de Estoque')
@section('content')
<h4 class="mb-3">Historico de Movimentacoes</h4>
<div class="card border-0 shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Data</th><th>Medicamento</th><th>Tipo</th><th>Qtd</th><th>Usuario</th><th>Obs</th></tr></thead>
        <tbody>
        @foreach($movimentos as $mov)
        <tr>
            <td>{{ $mov->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $mov->medicamento->nome_comercial }}</td>
            <td><span class="badge bg-secondary">{{ ucfirst($mov->tipo) }}</span></td>
            <td>{{ $mov->quantidade }}</td>
            <td>{{ $mov->user->name }}</td>
            <td>{{ $mov->observacao }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $movimentos->links() }}
<a href="{{ route('estoque.index') }}" class="btn btn-link mt-2">Voltar</a>
@endsection
