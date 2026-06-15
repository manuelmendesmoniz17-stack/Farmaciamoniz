@extends('layouts.app')
@section('title', $cliente->exists ? 'Editar Cliente' : 'Novo Cliente')
@section('content')
<h4 class="mb-3">{{ $cliente->exists ? 'Editar' : 'Novo' }} Cliente</h4>
<div class="card border-0 shadow-sm"><div class="card-body">
    <form method="POST" action="{{ $cliente->exists ? route('clientes.update', $cliente) : route('clientes.store') }}">
        @csrf @if($cliente->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nome</label><input name="nome" class="form-control" value="{{ old('nome', $cliente->nome) }}" required></div>
            <div class="col-md-3"><label class="form-label">Telefone</label><input name="telefone" class="form-control" value="{{ old('telefone', $cliente->telefone) }}"></div>
            <div class="col-md-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email) }}"></div>
            <div class="col-12"><label class="form-label">Endereco</label><textarea name="endereco" class="form-control" rows="2">{{ old('endereco', $cliente->endereco) }}</textarea></div>
        </div>
        <div class="mt-3"><button class="btn btn-primary">Salvar</button><a href="{{ route('clientes.index') }}" class="btn btn-link">Cancelar</a></div>
    </form>
</div></div>
@endsection
