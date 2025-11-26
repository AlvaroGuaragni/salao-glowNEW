<?php

namespace App\Http\Controllers;

use App\Models\ClienteExtra;
use Illuminate\Http\Request;

class ClienteExtraController extends Controller
{
    public function index(Request $request)
    {
        $query = ClienteExtra::query();

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', '%' . $busca . '%')
                    ->orWhere('email', 'like', '%' . $busca . '%')
                    ->orWhere('telefone', 'like', '%' . $busca . '%');
            });
        }

        $clientes = $query->orderBy('nome')->get();

        return view('cliente-extra.list', compact('clientes'));
    }

    public function create()
    {
        $cliente = new ClienteExtra();
        return view('cliente-extra.form', compact('cliente'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:cliente_extras',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:10',
            'observacoes' => 'nullable|string',
        ]);

        ClienteExtra::create($validated);

        return redirect()->route('cliente-extra.index')->with('success', 'Cliente cadastrado com sucesso.');
    }

    public function show(ClienteExtra $clienteExtra)
    {
        //
    }

    public function edit(ClienteExtra $clienteExtra)
    {
        $cliente = $clienteExtra;
        return view('cliente-extra.form', compact('cliente'));
    }

    public function update(Request $request, ClienteExtra $clienteExtra)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|unique:cliente_extras,email,' . $clienteExtra->id,
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:10',
            'observacoes' => 'nullable|string',
        ]);

        $clienteExtra->update($validated);

        return redirect()->route('cliente-extra.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(ClienteExtra $clienteExtra)
    {
        $clienteExtra->delete();

        return redirect()->route('cliente-extra.index')->with('success', 'Cliente excluído com sucesso.');
    }
}
