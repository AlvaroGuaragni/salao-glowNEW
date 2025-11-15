<?php
namespace App\Http\Controllers;
use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function index(Request $request)
    {
        $query = Servico::query();
        if ($request->has('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }
        $servicos = $query->paginate(15);
        $servicos = $query->paginate(15);
        return view('servicos.list', compact('servicos'));
    }

    public function create()
    {
        $servico = new Servico();
        return view('servicos.form', compact('servico'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:250',
        $validated = $request->validate([
            'nome' => 'required|string|max:250',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'duracao' => 'required|integer|min:1',
        ]);
        Servico::create($request->all());
        return redirect()->route('servicos.index')->with('success', 'Serviço cadastrado com sucesso.');
        Servico::create($validated);
        return redirect()->route('servicos.index')->with('success', 'Serviço cadastrado com sucesso.');
    }

    public function edit(Servico $servico)
    {
        return view('servicos.form', compact('servico'));
    }

    public function update(Request $request, Servico $servico)
    {
        $request->validate([
            'nome' => 'required|string|max:250',
        $validated = $request->validate([
            'nome' => 'required|string|max:250',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'duracao' => 'required|integer|min:1',
        ]);
        $servico->update($request->all());
        return redirect()->route('servicos.index')->with('success', 'Serviço atualizado com sucesso.');
        $servico->update($validated);
        return redirect()->route('servicos.index')->with('success', 'Serviço atualizado com sucesso.');
    }

    public function destroy(Servico $servico)
    {
        $servico->delete();
        return redirect()->route('servicos.index')->with('success', 'Serviço excluído com sucesso.');
    }

    public function listForClient(Request $request)
    {
        $query = Servico::query();
        if ($request->has('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }
        $servicos = $query->orderBy('nome')->paginate(10);
        return view('servicos.list-cliente', compact('servicos'));
        return redirect()->route('servicos.index')->with('success', 'Serviço excluído com sucesso.');
    }

    public function listForClient(Request $request)
    {
        $query = Servico::query();
        if ($request->has('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }
        $servicos = $query->orderBy('nome')->paginate(10);
        return view('servicos.list-cliente', compact('servicos'));
    }
}