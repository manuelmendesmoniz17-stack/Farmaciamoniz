@extends('layouts.app')
@section('title', 'Lucro')
@section('content')
<h4 class="mb-3">Relatorio de Lucro</h4>
<form class="mb-3" method="GET"><input type="month" name="mes" class="form-control d-inline-block" style="width:auto" value="{{ $mes }}"><button class="btn btn-primary">Filtrar</button></form>
<div class="row g-3">
    <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Receita</small><div class="fs-4 fw-bold text-success">{{ number_format($receita, 2, ',', '.') }} Kz</div></div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Custo</small><div class="fs-4 fw-bold text-danger">{{ number_format($custo, 2, ',', '.') }} Kz</div></div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm"><div class="card-body"><small class="text-muted">Lucro</small><div class="fs-4 fw-bold text-primary">{{ number_format($lucro, 2, ',', '.') }} Kz</div></div></div></div>
</div>
<a href="{{ route('relatorios.index') }}" class="btn btn-link mt-2">Voltar</a>
@endsection
