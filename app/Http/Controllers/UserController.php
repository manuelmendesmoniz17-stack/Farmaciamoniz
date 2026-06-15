<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $users = User::when($search, fn ($q) => $q->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('username', 'like', "%{$search}%"))
            ->orderBy('name')
            ->paginate(10);

        return view('usuarios.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('usuarios.form', ['user' => new User]);
    }

    public function store(Request $request)
    {
        $data = $this->validateUser($request);
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario criado com sucesso.');
    }

    public function edit(User $usuario)
    {
        return view('usuarios.form', ['user' => $usuario]);
    }

    public function update(Request $request, User $usuario)
    {
        $data = $this->validateUser($request, $usuario->id);
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario atualizado com sucesso.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'Nao pode excluir o proprio usuario.');
        }
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario excluido com sucesso.');
    }

    private function validateUser(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'username' => ['required', 'string', Rule::unique('users')->ignore($id)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,funcionario',
            'password' => [$id ? 'nullable' : 'required', 'string', 'min:6'],
        ]);
    }
}
