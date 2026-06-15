<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('relatorios.index');
    }

    public function vendasDiarias(Request $request)
    {
        $data = $request->get('data', today()->toDateString());
        $vendas = Venda::with(['cliente', 'user'])->whereDate('created_at', $data)->get();
        $total = $vendas->sum('total');

        return view('relatorios.vendas-diarias', compact('vendas', 'total', 'data'));
    }

    public function vendasMensais(Request $request)
    {
        $mes = $request->get('mes', now()->format('Y-m'));
        $vendas = Venda::whereRaw("strftime('%Y-%m', created_at) = ?", [$mes])
            ->select(DB::raw("strftime('%d', created_at) as dia"), DB::raw('SUM(total) as total'), DB::raw('COUNT(*) as qtd'))
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();
        $totalMes = Venda::whereRaw("strftime('%Y-%m', created_at) = ?", [$mes])->sum('total');

        return view('relatorios.vendas-mensais', compact('vendas', 'totalMes', 'mes'));
    }

    public function estoqueAtual()
    {
        $medicamentos = Medicamento::with('fornecedor')->orderBy('nome_comercial')->get();
        $valorTotal = $medicamentos->sum(fn ($m) => $m->quantidade * $m->preco_compra);

        return view('relatorios.estoque', compact('medicamentos', 'valorTotal'));
    }

    public function produtosVencidos()
    {
        $medicamentos = Medicamento::whereNotNull('data_validade')
            ->where('data_validade', '<', today())
            ->orderBy('data_validade')
            ->get();

        return view('relatorios.vencidos', compact('medicamentos'));
    }

    public function proximosVencimento()
    {
        $medicamentos = Medicamento::whereNotNull('data_validade')
            ->whereBetween('data_validade', [today(), today()->addDays(30)])
            ->orderBy('data_validade')
            ->get();

        return view('relatorios.proximos-vencimento', compact('medicamentos'));
    }

    public function lucro(Request $request)
    {
        $mes = $request->get('mes', now()->format('Y-m'));
        $itens = VendaItem::whereHas('venda', fn ($q) => $q->whereRaw("strftime('%Y-%m', created_at) = ?", [$mes]))
            ->with('medicamento')
            ->get();

        $receita = $itens->sum('subtotal');
        $custo = $itens->sum(fn ($i) => $i->medicamento->preco_compra * $i->quantidade);
        $lucro = $receita - $custo;

        return view('relatorios.lucro', compact('receita', 'custo', 'lucro', 'mes'));
    }
}
