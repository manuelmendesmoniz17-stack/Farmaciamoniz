@extends('layouts.app')
@section('title', 'Configuracoes')
@section('content')
<h4 class="mb-3">Configuracoes</h4>
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>Dados da Farmacia</strong></div>
            <div class="card-body">
                <form method="POST" action="{{ route('configuracoes.update') }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3"><label class="form-label">Nome</label><input name="nome_farmacia" class="form-control" value="{{ old('nome_farmacia', $config->nome_farmacia) }}" required></div>
                    <div class="mb-3"><label class="form-label">Logotipo</label><input type="file" name="logotipo" class="form-control" accept="image/*">
                        @if($config->logotipo)<img src="{{ asset('storage/'.$config->logotipo) }}" class="mt-2" height="60">@endif
                    </div>
                    <div class="mb-3"><label class="form-label">Endereco</label><textarea name="endereco" class="form-control" rows="2">{{ old('endereco', $config->endereco) }}</textarea></div>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Telefone</label><input name="telefone" class="form-control" value="{{ old('telefone', $config->telefone) }}"></div>
                        <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email', $config->email) }}"></div>
                    </div>
                    <button class="btn btn-primary mt-3">Salvar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>Sistema</strong></div>
            <div class="card-body">
                <p class="text-muted small">Backup e restauracao da base de dados SQLite.</p>
                <a href="{{ route('configuracoes.backup') }}" class="btn btn-outline-primary w-100 mb-3">Fazer Backup</a>
                <form method="POST" action="{{ route('configuracoes.restore') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2"><input type="file" name="backup" class="form-control" required></div>
                    <button class="btn btn-outline-danger w-100" onclick="return confirm('Isto substituira a base de dados actual. Continuar?')">Restaurar Base de Dados</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
