@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <h4 class="text-center mb-1 fw-bold">Gestao Farmaceutica</h4>
                <p class="text-center text-muted mb-4">Entre com suas credenciais</p>

                @if(session('status'))
                    <div class="alert alert-info">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Usuario</label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                               value="{{ old('username') }}" required autofocus>
                        @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Lembrar-me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="text-decoration-none small">Recuperar senha</a>
                </div>
            </div>
        </div>
        <p class="text-center text-muted small mt-3">admin / admin123 ou funcionario / func123</p>
    </div>
</div>
@endsection
