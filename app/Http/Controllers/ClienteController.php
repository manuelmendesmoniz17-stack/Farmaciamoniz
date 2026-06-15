<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $clientes = Cliente::when($search, fn ($q) => $q->where('nome', 'like', "%{$search}%")
            ->orWhere('telefone', 'like', "%{$search}%"))
            ->orderBy('nome')
            ->paginate(10);

        return view('clientes.index', compact('clientes', 'search'));
    }

    public function create()
    {
        return view('clientes.form', ['cliente' => new Cliente]);
    }

    public function store(Request $request)
    {
        Cliente::create($this->validateCliente($request));

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado.');
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.form', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $cliente->update($this->validateCliente($request));

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente excluido.');
    }

    private function validateCliente(Request $request): array
    {
        return $request->validate([
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string',
        ]);
    }
}
