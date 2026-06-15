@extends('layouts.app')
@section('title', 'Fornecedores')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Fornecedores</h4>
    <a href="{{ route('fornecedores.create') }}" class="btn btn-primary btn-sm">Novo</a>
</div>
<div class="card border-0 shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="table-light"><tr><th>Nome</th><th>NIF</th><th>Telefone</th><th>Email</th><th></th></tr></thead>
        <tbody>
        @foreach($fornecedores as $f)
        <tr>
            <td>{{ $f->nome }}</td><td>{{ $f->nif }}</td><td>{{ $f->telefone }}</td><td>{{ $f->email }}</td>
            <td class="text-end">
                <a href="{{ route('fornecedores.edit', $f) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                <form action="{{ route('fornecedores.destroy', $f) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir?')">
                    @csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $fornecedores->links() }}
@endsection
