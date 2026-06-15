@extends('layouts.app')
@section('title', 'Usuarios')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Usuarios</h4>
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">Novo Usuario</a>
</div>
<form class="mb-3" method="GET">
    <div class="input-group" style="max-width:400px">
        <input type="text" name="search" class="form-control" placeholder="Pesquisar..." value="{{ $search }}">
        <button class="btn btn-outline-secondary">Buscar</button>
    </div>
</form>
<div class="card border-0 shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Nome</th><th>Email</th><th>Username</th><th>Nivel</th><th></th></tr></thead>
        <tbody>
        @foreach($users as $u)
        <tr>
            <td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ $u->username }}</td>
            <td><span class="badge {{ $u->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">{{ ucfirst($u->role) }}</span></td>
            <td class="text-end">
                <a href="{{ route('usuarios.edit', $u) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                <form action="{{ route('usuarios.destroy', $u) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $users->links() }}
@endsection
