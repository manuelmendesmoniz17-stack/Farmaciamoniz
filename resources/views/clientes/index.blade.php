@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Clientes</h4>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm">Novo</a>
</div>
<form class="mb-3" method="GET">
    <div class="input-group" style="max-width:400px">
        <input type="text" name="search" class="form-control" placeholder="Pesquisar..." value="{{ $search }}">
        <button class="btn btn-outline-secondary">Buscar</button>
    </div>
</form>
<div class="card border-0 shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Nome</th><th>Telefone</th><th>Email</th><th>Endereco</th><th></th></tr></thead>
        <tbody>
        @foreach($clientes as $c)
        <tr>
            <td>{{ $c->nome }}</td><td>{{ $c->telefone }}</td><td>{{ $c->email }}</td><td>{{ $c->endereco }}</td>
            <td class="text-end">
                <a href="{{ route('clientes.edit', $c) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                <form action="{{ route('clientes.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir?')">
                    @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $clientes->links() }}
@endsection
