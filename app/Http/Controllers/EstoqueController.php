<?php

namespace App\Http\Controllers;

use App\Models\EstoqueMovimento;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstoqueController extends Controller
{
    public function index(Request $request)
    {
        $medicamentos = Medicamento::with('fornecedor')
            ->when($request->search, fn ($q) => $q->where('nome_comercial', 'like', '%'.$request->search.'%'))
            ->orderBy('nome_comercial')
            ->paginate(10);

        $alertasBaixo = Medicamento::whereColumn('quantidade', '<=', 'estoque_minimo')->get();
        $alertasValidade = Medicamento::whereNotNull('data_validade')
            ->where('data_validade', '<=', now()->addDays(30))
            ->orderBy('data_validade')
            ->get();

        return view('estoque.index', compact('medicamentos', 'alertasBaixo', 'alertasValidade'));
    }

    public function historico()
    {
        $movimentos = EstoqueMovimento::with(['medicamento', 'user'])
            ->latest()
            ->paginate(15);

        return view('estoque.historico', compact('movimentos'));
    }

    public function movimento(Request $request)
    {
        $data = $request->validate([
            'medicamento_id' => 'required|exists:medicamentos,id',
            'tipo' => 'required|in:compra,doacao,ajuste,venda,perda,vencido',
            'quantidade' => 'required|integer|min:1',
            'observacao' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($data) {
            $medicamento = Medicamento::lockForUpdate()->findOrFail($data['medicamento_id']);
            $entrada = in_array($data['tipo'], ['compra', 'doacao', 'ajuste']);

            if (! $entrada && $medicamento->quantidade < $data['quantidade']) {
                abort(422, 'Quantidade insuficiente em estoque.');
            }

            $medicamento->quantidade += $entrada ? $data['quantidade'] : -$data['quantidade'];
            $medicamento->save();

            EstoqueMovimento::create([
                'medicamento_id' => $medicamento->id,
                'user_id' => auth()->id(),
                'tipo' => $data['tipo'],
                'quantidade' => $data['quantidade'],
                'observacao' => $data['observacao'],
            ]);
        });

        return back()->with('success', 'Movimentacao registada com sucesso.');
    }
}
