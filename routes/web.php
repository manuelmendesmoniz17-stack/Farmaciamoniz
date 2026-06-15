<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/recuperar-senha', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/recuperar-senha', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/redefinir-senha/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/redefinir-senha', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('medicamentos', MedicamentoController::class);
    Route::get('/api/medicamentos/buscar', [MedicamentoController::class, 'search'])->name('medicamentos.search');

    Route::get('/estoque', [EstoqueController::class, 'index'])->name('estoque.index');
    Route::get('/estoque/historico', [EstoqueController::class, 'historico'])->name('estoque.historico');
    Route::post('/estoque/movimento', [EstoqueController::class, 'movimento'])->name('estoque.movimento');

    Route::resource('clientes', ClienteController::class);
    Route::resource('fornecedores', FornecedorController::class);

    Route::get('/vendas/pdv', [VendaController::class, 'pdv'])->name('vendas.pdv');
    Route::post('/vendas', [VendaController::class, 'store'])->name('vendas.store');
    Route::get('/vendas/historico', [VendaController::class, 'historico'])->name('vendas.historico');
    Route::get('/vendas/{venda}/recibo', [VendaController::class, 'recibo'])->name('vendas.recibo');
    Route::get('/vendas/{venda}/fatura', [VendaController::class, 'fatura'])->name('vendas.fatura');

    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/', [RelatorioController::class, 'index'])->name('index');
        Route::get('/vendas-diarias', [RelatorioController::class, 'vendasDiarias'])->name('vendas-diarias');
        Route::get('/vendas-mensais', [RelatorioController::class, 'vendasMensais'])->name('vendas-mensais');
        Route::get('/estoque', [RelatorioController::class, 'estoqueAtual'])->name('estoque');
        Route::get('/vencidos', [RelatorioController::class, 'produtosVencidos'])->name('vencidos');
        Route::get('/proximos-vencimento', [RelatorioController::class, 'proximosVencimento'])->name('proximos-vencimento');
        Route::get('/lucro', [RelatorioController::class, 'lucro'])->name('lucro');
    });

    Route::middleware('admin')->group(function () {
        Route::resource('usuarios', UserController::class)->parameters(['usuarios' => 'usuario']);

        Route::get('/configuracoes', [ConfiguracaoController::class, 'index'])->name('configuracoes.index');
        Route::put('/configuracoes', [ConfiguracaoController::class, 'update'])->name('configuracoes.update');
        Route::get('/configuracoes/backup', [ConfiguracaoController::class, 'backup'])->name('configuracoes.backup');
        Route::post('/configuracoes/restaurar', [ConfiguracaoController::class, 'restore'])->name('configuracoes.restore');
    });
});
