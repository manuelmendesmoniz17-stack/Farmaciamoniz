@extends('layouts.app')

@section('title', 'Recuperar Senha')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="mb-3">Recuperar Senha</h5>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Link</button>
                    <a href="{{ route('login') }}" class="btn btn-link">Voltar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
