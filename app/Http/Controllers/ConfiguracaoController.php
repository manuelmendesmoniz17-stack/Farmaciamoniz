<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        $config = Configuracao::atual();

        return view('configuracoes.index', compact('config'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'nome_farmacia' => 'required|string|max:255',
            'endereco' => 'nullable|string',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logotipo' => 'nullable|image|max:2048',
        ]);

        $config = Configuracao::atual();

        if ($request->hasFile('logotipo')) {
            if ($config->logotipo) {
                File::delete(public_path('storage/'.$config->logotipo));
            }
            $data['logotipo'] = $request->file('logotipo')->store('logos', 'public');
        } else {
            unset($data['logotipo']);
        }

        $config->update($data);

        return back()->with('success', 'Configuracoes atualizadas.');
    }

    public function backup()
    {
        $dbPath = database_path('database.sqlite');
        if (! file_exists($dbPath)) {
            return back()->with('error', 'Base de dados nao encontrada.');
        }

        return response()->download($dbPath, 'farmacia_backup_'.now()->format('Y-m-d_His').'.sqlite');
    }

    public function restore(Request $request)
    {
        $request->validate(['backup' => 'required|file']);

        $dbPath = database_path('database.sqlite');
        $request->file('backup')->move(dirname($dbPath), 'database.sqlite');

        return back()->with('success', 'Base de dados restaurada. Reinicie a aplicacao.');
    }
}
