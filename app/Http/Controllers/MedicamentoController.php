<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $medicamentos = Medicamento::with('fornecedor')
            ->when($search, fn ($q) => $q->where('nome_comercial', 'like', "%{$search}%")
                ->orWhere('codigo', 'like', "%{$search}%")
                ->orWhere('principio_ativo', 'like', "%{$search}%"))
            ->orderBy('nome_comercial')
            ->paginate(10);

        return view('medicamentos.index', compact('medicamentos', 'search'));
    }

    public function create()
    {
        return view('medicamentos.form', [
            'medicamento' => new Medicamento,
            'fornecedores' => Fornecedor::orderBy('nome')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Medicamento::create($this->validateMedicamento($request));

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento cadastrado.');
    }

    public function edit(Medicamento $medicamento)
    {
        return view('medicamentos.form', [
            'medicamento' => $medicamento,
            'fornecedores' => Fornecedor::orderBy('nome')->get(),
        ]);
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $medicamento->update($this->validateMedicamento($request, $medicamento->id));

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento atualizado.');
    }

    public function destroy(Medicamento $medicamento)
    {
        $medicamento->delete();

        return redirect()->route('medicamentos.index')->with('success', 'Medicamento excluido.');
    }

    public function search(Request $request)
    {
        $q = $request->get('q', '');
        $medicamentos = Medicamento::where('quantidade', '>', 0)
            ->where(fn ($query) => $query->where('nome_comercial', 'like', "%{$q}%")
                ->orWhere('codigo', 'like', "%{$q}%"))
            ->limit(10)
            ->get(['id', 'codigo', 'nome_comercial', 'preco_venda', 'quantidade']);

        return response()->json($medicamentos);
    }

    private function validateMedicamento(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'codigo' => 'required|string|unique:medicamentos,codigo,'.$id,
            'nome_comercial' => 'required|string|max:255',
            'principio_ativo' => 'nullable|string|max:255',
            'categoria' => 'nullable|string|max:100',
            'fabricante' => 'nullable|string|max:255',
            'lote' => 'nullable|string|max:50',
            'data_fabricacao' => 'nullable|date',
            'data_validade' => 'nullable|date',
            'preco_compra' => 'required|numeric|min:0',
            'preco_venda' => 'required|numeric|min:0',
            'quantidade' => 'required|integer|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'fornecedor_id' => 'nullable|exists:fornecedores,id',
        ]);
    }
}
