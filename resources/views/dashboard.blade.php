@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Dashboard</h4>
        <small class="text-muted">Bem-vindo, {{ auth()->user()->name }}</small>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-primary bg-opacity-10 text-primary"><i class="bi bi-capsule"></i></div>
                <div>
                    <div class="text-muted small">Total Medicamentos</div>
                    <div class="fs-4 fw-bold">{{ $totalMedicamentos }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-warning bg-opacity-10 text-warning"><i class="bi bi-exclamation-triangle"></i></div>
                <div>
                    <div class="text-muted small">Estoque Baixo</div>
                    <div class="fs-4 fw-bold">{{ $estoqueBaixo }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-success bg-opacity-10 text-success"><i class="bi bi-cash-stack"></i></div>
                <div>
                    <div class="text-muted small">Vendas do Dia</div>
                    <div class="fs-4 fw-bold">{{ number_format($vendasDia, 2, ',', '.') }} Kz</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-info bg-opacity-10 text-info"><i class="bi bi-people"></i></div>
                <div>
                    <div class="text-muted small">Clientes</div>
                    <div class="fs-4 fw-bold">{{ $totalClientes }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>Vendas por Mes</strong></div>
            <div class="card-body"><canvas id="chartVendas" height="120"></canvas></div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>Mais Vendidos</strong></div>
            <div class="card-body"><canvas id="chartTop" height="180"></canvas></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white text-warning"><strong>Alertas - Estoque Minimo</strong></div>
            <ul class="list-group list-group-flush">
                @forelse($alertasEstoque as $m)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $m->nome_comercial }}</span>
                    <span class="badge bg-warning text-dark">{{ $m->quantidade }} un.</span>
                </li>
                @empty
                <li class="list-group-item text-muted">Nenhum alerta</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white text-danger"><strong>Alertas - Validade</strong></div>
            <ul class="list-group list-group-flush">
                @forelse($alertasValidade as $m)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $m->nome_comercial }}</span>
                    <span class="badge {{ $m->isVencido() ? 'bg-danger' : 'bg-warning text-dark' }}">
                        {{ $m->data_validade->format('d/m/Y') }}
                    </span>
                </li>
                @empty
                <li class="list-group-item text-muted">Nenhum alerta</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('chartVendas'), {
    type: 'line',
    data: {
        labels: {!! json_encode($vendasPorMes->pluck('mes')) !!},
        datasets: [{ label: 'Vendas (Kz)', data: {!! json_encode($vendasPorMes->pluck('total')) !!},
            borderColor: '#0d6efd', backgroundColor: 'rgba(13,110,253,.1)', fill: true, tension: .3 }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});
new Chart(document.getElementById('chartTop'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($maisVendidos->map(fn($i) => $i->medicamento?->nome_comercial ?? 'N/A')) !!},
        datasets: [{ label: 'Qtd', data: {!! json_encode($maisVendidos->pluck('total_vendido')) !!},
            backgroundColor: '#198754' }]
    },
    options: { responsive: true, plugins: { legend: { display: false } }, indexAxis: 'y' }
});
</script>
@endpush
