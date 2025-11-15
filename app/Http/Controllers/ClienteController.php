<?php
namespace App\Http\Controllers;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();
        if ($request->has('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('nome', 'like', '%' . $busca . '%')
                  ->orWhere('cpf', 'like', '%' . $busca . '%')
                  ->orWhere('email', 'like', '%' . $busca . '%');
            });
        }
        $clientes = $query->paginate(15);
        return view('cliente.list', compact('clientes'));
    }

    public function create()
    {
        $cliente = new Cliente();
        return view('cliente.form', compact('cliente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:20|unique:clientes',
            'email' => 'nullable|email|max:255|unique:clientes',
            'telefone' => 'nullable|string|max:20',
        ]);

        Cliente::create($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso.');
    }

    public function edit(Cliente $cliente)
    {
        return view('cliente.form', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:20|unique:clientes,cpf,' . $cliente->id,
            'email' => 'nullable|email|max:255|unique:clientes,email,' . $cliente->id,
            'telefone' => 'nullable|string|max:20',
        ]);

        $cliente->update($request->all());
        return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso.');
    }
}