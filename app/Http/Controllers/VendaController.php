<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\EstoqueMovimento;
use App\Models\Medicamento;
use App\Models\Venda;
use App\Models\VendaItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    public function pdv()
    {
        $clientes = Cliente::orderBy('nome')->get();

        return view('vendas.pdv', compact('clientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'desconto' => 'nullable|numeric|min:0',
            'forma_pagamento' => 'required|in:dinheiro,multicaixa,transferencia',
            'itens' => 'required|array|min:1',
            'itens.*.medicamento_id' => 'required|exists:medicamentos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
        ]);

        try {
            $venda = DB::transaction(function () use ($data) {
            $subtotal = 0;
            $itensProcessados = [];

            foreach ($data['itens'] as $item) {
                $med = Medicamento::lockForUpdate()->findOrFail($item['medicamento_id']);
                if ($med->quantidade < $item['quantidade']) {
                    throw new \RuntimeException("Estoque insuficiente para {$med->nome_comercial}");
                }
                $itemSubtotal = $med->preco_venda * $item['quantidade'];
                $subtotal += $itemSubtotal;
                $itensProcessados[] = ['med' => $med, 'qty' => $item['quantidade'], 'subtotal' => $itemSubtotal];
            }

            $desconto = $data['desconto'] ?? 0;
            $total = max(0, $subtotal - $desconto);

            $venda = Venda::create([
                'numero_fatura' => 'FAT-'.now()->format('Ymd').'-'.str_pad((Venda::whereDate('created_at', today())->count() + 1), 4, '0', STR_PAD_LEFT),
                'cliente_id' => $data['cliente_id'] ?? null,
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'desconto' => $desconto,
                'total' => $total,
                'forma_pagamento' => $data['forma_pagamento'],
            ]);

            foreach ($itensProcessados as $item) {
                VendaItem::create([
                    'venda_id' => $venda->id,
                    'medicamento_id' => $item['med']->id,
                    'quantidade' => $item['qty'],
                    'preco_unitario' => $item['med']->preco_venda,
                    'subtotal' => $item['subtotal'],
                ]);

                $item['med']->decrement('quantidade', $item['qty']);

                EstoqueMovimento::create([
                    'medicamento_id' => $item['med']->id,
                    'user_id' => auth()->id(),
                    'venda_id' => $venda->id,
                    'tipo' => 'venda',
                    'quantidade' => $item['qty'],
                    'observacao' => 'Venda '.$venda->numero_fatura,
                ]);
            }

            return $venda;
            });
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('vendas.recibo', $venda)->with('success', 'Venda concluida.');
    }

    public function historico(Request $request)
    {
        $vendas = Venda::with(['cliente', 'user'])
            ->when($request->data, fn ($q) => $q->whereDate('created_at', $request->data))
            ->latest()
            ->paginate(15);

        return view('vendas.historico', compact('vendas'));
    }

    public function recibo(Venda $venda)
    {
        $venda->load(['itens.medicamento', 'cliente', 'user']);

        return view('vendas.recibo', compact('venda'));
    }

    public function fatura(Venda $venda)
    {
        $venda->load(['itens.medicamento', 'cliente', 'user']);

        return view('vendas.fatura', compact('venda'));
    }
}
