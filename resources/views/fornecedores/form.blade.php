@extends('layouts.app')
@section('title', $fornecedor->exists ? 'Editar Fornecedor' : 'Novo Fornecedor')
@section('content')
<h4 class="mb-3">{{ $fornecedor->exists ? 'Editar' : 'Novo' }} Fornecedor</h4>
<div class="card border-0 shadow-sm"><div class="card-body">
    <form method="POST" action="{{ $fornecedor->exists ? route('fornecedores.update', $fornecedor) : route('fornecedores.store') }}">
        @csrf @if($fornecedor->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nome</label><input name="nome" class="form-control" value="{{ old('nome', $fornecedor->nome) }}" required></div>
            <div class="col-md-3"><label class="form-label">NIF</label><input name="nif" class="form-control" value="{{ old('nif', $fornecedor->nif) }}"></div>
            <div class="col-md-3"><label class="form-label">Telefone</label><input name="telefone" class="form-control" value="{{ old('telefone', $fornecedor->telefone) }}"></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $fornecedor->email) }}"></div>
            <div class="col-12"><label class="form-label">Endereco</label><textarea name="endereco" class="form-control" rows="2">{{ old('endereco', $fornecedor->endereco) }}</textarea></div>
        </div>
        <div class="mt-3"><button class="btn btn-primary">Salvar</button><a href="{{ route('fornecedores.index') }}" class="btn btn-link">Cancelar</a></div>
    </form>
</div></div>
@endsection
