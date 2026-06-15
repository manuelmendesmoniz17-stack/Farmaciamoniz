<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::orderBy('nome')->paginate(10);

        return view('fornecedores.index', compact('fornecedores'));
    }

    public function create()
    {
        return view('fornecedores.form', ['fornecedor' => new Fornecedor]);
    }

    public function store(Request $request)
    {
        Fornecedor::create($this->validateFornecedor($request));

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor adicionado.');
    }

    public function edit(Fornecedor $fornecedor)
    {
        return view('fornecedores.form', compact('fornecedor'));
    }

    public function update(Request $request, Fornecedor $fornecedor)
    {
        $fornecedor->update($this->validateFornecedor($request));

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado.');
    }

    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor excluido.');
    }

    private function validateFornecedor(Request $request): array
    {
        return $request->validate([
            'nome' => 'required|string|max:255',
            'nif' => 'nullable|string|max:50',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string',
        ]);
    }
}
