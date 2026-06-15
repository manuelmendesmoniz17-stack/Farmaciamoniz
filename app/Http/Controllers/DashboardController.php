<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Medicamento;
use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMedicamentos = Medicamento::count();
        $estoqueBaixo = Medicamento::whereColumn('quantidade', '<=', 'estoque_minimo')->count();
        $vendasDia = Venda::whereDate('created_at', today())->sum('total');
        $totalClientes = Cliente::count();

        $vendasPorMes = Venda::select(
            DB::raw("strftime('%Y-%m', created_at) as mes"),
            DB::raw('SUM(total) as total')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $maisVendidos = VendaItem::select('medicamento_id', DB::raw('SUM(quantidade) as total_vendido'))
            ->with('medicamento')
            ->groupBy('medicamento_id')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();

        $alertasEstoque = Medicamento::whereColumn('quantidade', '<=', 'estoque_minimo')->limit(5)->get();
        $alertasValidade = Medicamento::whereNotNull('data_validade')
            ->where('data_validade', '<=', now()->addDays(30))
            ->orderBy('data_validade')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalMedicamentos', 'estoqueBaixo', 'vendasDia', 'totalClientes',
            'vendasPorMes', 'maisVendidos', 'alertasEstoque', 'alertasValidade'
        ));
    }
}
