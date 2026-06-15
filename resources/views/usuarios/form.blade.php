@extends('layouts.app')
@section('title', $user->exists ? 'Editar Usuario' : 'Novo Usuario')
@section('content')
<h4 class="mb-3">{{ $user->exists ? 'Editar' : 'Novo' }} Usuario</h4>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ $user->exists ? route('usuarios.update', $user) : route('usuarios.store') }}">
            @csrf @if($user->exists) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Nome</label><input name="name" class="form-control" value="{{ old('name', $user->name) }}" required></div>
                <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required></div>
                <div class="col-md-4"><label class="form-label">Telefone</label><input name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"></div>
                <div class="col-md-4"><label class="form-label">Username</label><input name="username" class="form-control" value="{{ old('username', $user->username) }}" required></div>
                <div class="col-md-4"><label class="form-label">Nivel</label>
                    <select name="role" class="form-select" required>
                        <option value="funcionario" @selected(old('role', $user->role) === 'funcionario')>Funcionario</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Administrador</option>
                    </select>
                </div>
                <div class="col-md-6"><label class="form-label">Senha {{ $user->exists ? '(deixe vazio para manter)' : '' }}</label><input type="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }}></div>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary">Salvar</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-link">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
