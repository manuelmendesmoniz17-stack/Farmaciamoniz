<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestao Farmaceutica')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --sidebar-width: 260px; --primary: #0d6efd; --sidebar-bg: #1e293b; }
        body { background: #f1f5f9; min-height: 100vh; }
        .sidebar {
            width: var(--sidebar-width); min-height: 100vh; background: var(--sidebar-bg);
            position: fixed; top: 0; left: 0; z-index: 1000;
        }
        .sidebar .brand { padding: 1.25rem; color: #fff; font-weight: 700; border-bottom: 1px solid #334155; }
        .sidebar .nav-link {
            color: #94a3b8; padding: .6rem 1.25rem; border-radius: 0;
            font-size: .9rem;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: #334155; }
        .sidebar .nav-link i { width: 20px; margin-right: .5rem; }
        .sidebar .sub-link { padding-left: 2.5rem; font-size: .85rem; }
        .main-content { margin-left: var(--sidebar-width); padding: 1.5rem; }
        .card-stat { border: none; border-radius: .75rem; box-shadow: 0 1px 3px rgba(0,0,0,.08); }
        .card-stat .stat-icon {
            width: 48px; height: 48px; border-radius: .5rem;
            display: flex; align-items: center; justify-content: center; font-size: 1.25rem;
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: .3s; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
        @media print { .sidebar, .no-print { display: none !important; } .main-content { margin: 0; } }
    </style>
    @stack('styles')
</head>
<body>
    @auth
    <nav class="sidebar" id="sidebar">
        <div class="brand">{{ \App\Models\Configuracao::atual()->nome_farmacia }}</div>
        <nav class="nav flex-column py-2">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('medicamentos.*') ? 'active' : '' }}" href="{{ route('medicamentos.index') }}">
                <i class="bi bi-capsule"></i> Medicamentos
            </a>
            <a class="nav-link sub-link" href="{{ route('medicamentos.create') }}">Cadastrar</a>
            <a class="nav-link sub-link" href="{{ route('medicamentos.index') }}">Listar</a>
            <a class="nav-link sub-link {{ request()->routeIs('estoque.*') ? 'active' : '' }}" href="{{ route('estoque.index') }}">Estoque</a>
            <a class="nav-link {{ request()->routeIs('vendas.*') ? 'active' : '' }}" href="{{ route('vendas.pdv') }}">
                <i class="bi bi-cart3"></i> Vendas
            </a>
            <a class="nav-link sub-link" href="{{ route('vendas.pdv') }}">Nova Venda</a>
            <a class="nav-link sub-link" href="{{ route('vendas.historico') }}">Historico</a>
            <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                <i class="bi bi-people"></i> Clientes
            </a>
            <a class="nav-link {{ request()->routeIs('fornecedores.*') ? 'active' : '' }}" href="{{ route('fornecedores.index') }}">
                <i class="bi bi-building"></i> Fornecedores
            </a>
            <a class="nav-link {{ request()->routeIs('relatorios.*') ? 'active' : '' }}" href="{{ route('relatorios.index') }}">
                <i class="bi bi-bar-chart"></i> Relatorios
            </a>
            @if(auth()->user()->isAdmin())
            <a class="nav-link {{ request()->routeIs('configuracoes.*') ? 'active' : '' }}" href="{{ route('configuracoes.index') }}">
                <i class="bi bi-gear"></i> Configuracoes
            </a>
            <a class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                <i class="bi bi-person-badge"></i> Usuarios
            </a>
            @endif
            <hr class="border-secondary mx-3">
            <form action="{{ route('logout') }}" method="POST" class="px-3">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-left"></i> Sair
                </button>
            </form>
        </nav>
    </nav>
    @endauth

    <main class="@auth main-content @else container py-5 @endauth">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
                {{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show no-print" role="alert">
                {{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @stack('scripts')
</body>
</html>
