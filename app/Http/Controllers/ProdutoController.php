<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::query();

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('nome', 'like', '%' . $busca . '%')
                    ->orWhere('marca', 'like', '%' . $busca . '%')
                    ;
            });
        }

        $produtos = $query->orderBy('nome')->get();

        return view('produtos.list', compact('produtos'));
    }

    public function create()
    {
        $produto = new Produto();
        return view('produtos.form', compact('produto'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
            'marca' => 'nullable|string|max:255',
        ]);

        Produto::create($validated);

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso.');
    }

    public function show(Produto $produto)
    {
        //
    }

    public function edit(Produto $produto)
    {
        return view('produtos.form', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'estoque' => 'required|integer|min:0',
            'marca' => 'nullable|string|max:255',
        ]);

        $produto->update($validated);

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso.');
    }
}
