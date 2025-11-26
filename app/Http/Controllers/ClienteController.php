<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', '%' . $busca . '%')
                    ->orWhere('cpf', 'like', '%' . $busca . '%')
                    ->orWhere('email', 'like', '%' . $busca . '%');
            });
        }

        $clientes = $query->orderBy('nome')->get();

        return view('cliente.list', compact('clientes'));
    }

    public function create()
    {
        $cliente = new Cliente();
        return view('cliente.form', compact('cliente'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:20|unique:clientes',
            'email' => 'nullable|email|max:255|unique:clientes',
            'telefone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        $dados = collect($validated)->except('foto')->toArray();

        if ($request->hasFile('foto')) {
            $dados['foto_path'] = $request->file('foto')->store('clientes', 'public');
        }

        Cliente::create($dados);

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso.');
    }

    public function edit(Cliente $cliente)
    {
        return view('cliente.form', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:20|unique:clientes,cpf,' . $cliente->id,
            'email' => 'nullable|email|max:255|unique:clientes,email,' . $cliente->id,
            'telefone' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
        ]);

        $dados = collect($validated)->except('foto')->toArray();

        if ($request->hasFile('foto')) {
            if ($cliente->foto_path) {
                Storage::disk('public')->delete($cliente->foto_path);
            }
            $dados['foto_path'] = $request->file('foto')->store('clientes', 'public');
        }

        $cliente->update($dados);

        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(Cliente $cliente)
    {
        if ($cliente->foto_path) {
            Storage::disk('public')->delete($cliente->foto_path);
        }

        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso.');
    }
}
