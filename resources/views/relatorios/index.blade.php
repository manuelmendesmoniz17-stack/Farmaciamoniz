@extends('layouts.app')
@section('title', 'Relatorios')
@section('content')
<h4 class="mb-4">Relatorios</h4>
<div class="row g-3">
    @foreach([
        ['Vendas Diarias', 'relatorios.vendas-diarias', 'bi-calendar-day'],
        ['Vendas Mensais', 'relatorios.vendas-mensais', 'bi-calendar-month'],
        ['Estoque Atual', 'relatorios.estoque', 'bi-boxes'],
        ['Produtos Vencidos', 'relatorios.vencidos', 'bi-x-circle'],
        ['Proximos da Validade', 'relatorios.proximos-vencimento', 'bi-clock'],
        ['Lucro', 'relatorios.lucro', 'bi-graph-up'],
    ] as [$titulo, $rota, $icon])
    <div class="col-md-4">
        <a href="{{ route($rota) }}" class="card border-0 shadow-sm text-decoration-none h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi {{ $icon }}"></i></div>
                <span class="text-dark fw-medium">{{ $titulo }}</span>
            </div>
        </a>
    </div>
    @endforeach
</div>
@endsection
