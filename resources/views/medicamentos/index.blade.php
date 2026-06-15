@extends('layouts.app')
@section('title', 'Medicamentos')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Medicamentos</h4>
    <a href="{{ route('medicamentos.create') }}" class="btn btn-primary btn-sm">Novo</a>
</div>
<form class="mb-3" method="GET">
    <div class="input-group" style="max-width:400px">
        <input type="text" name="search" class="form-control" placeholder="Pesquisar..." value="{{ $search }}">
        <button class="btn btn-outline-secondary">Buscar</button>
    </div>
</form>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Codigo</th><th>Nome</th><th>Categoria</th><th>Qtd</th><th>Preco Venda</th><th>Validade</th><th></th></tr></thead>
            <tbody>
            @foreach($medicamentos as $m)
            <tr>
                <td>{{ $m->codigo }}</td>
                <td>{{ $m->nome_comercial }}</td>
                <td>{{ $m->categoria }}</td>
                <td><span class="badge {{ $m->isEstoqueBaixo() ? 'bg-warning text-dark' : 'bg-success' }}">{{ $m->quantidade }}</span></td>
                <td>{{ number_format($m->preco_venda, 2, ',', '.') }} Kz</td>
                <td>{{ $m->data_validade?->format('d/m/Y') ?? '-' }}</td>
                <td class="text-end">
                    <a href="{{ route('medicamentos.edit', $m) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                    <form action="{{ route('medicamentos.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir?')">
                        @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{ $medicamentos->links() }}
@endsection
