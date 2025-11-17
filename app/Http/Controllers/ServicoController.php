<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicoController extends Controller
{
    public function index(Request $request)
    {
        $query = Servico::query();

        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }

        $servicos = $query->orderBy('nome')->paginate(15)->withQueryString();

        return view('servicos.list', compact('servicos'));
    }

    public function create()
    {
        $servico = new Servico();
        return view('servicos.form', compact('servico'));
    }

    public function store(Request $request)
    {
        $dados = $this->prepareServicoData($request);

        Servico::create($dados);

        return redirect()->route('servicos.index')->with('success', 'Serviço cadastrado com sucesso.');
    }

    public function edit(Servico $servico)
    {
        return view('servicos.form', compact('servico'));
    }

    public function update(Request $request, Servico $servico)
    {
        $dados = $this->prepareServicoData($request, $servico);

        $servico->update($dados);

        return redirect()->route('servicos.index')->with('success', 'Serviço atualizado com sucesso.');
    }

    public function destroy(Servico $servico)
    {
        $this->deleteImagem($servico);

        $servico->delete();

        return redirect()->route('servicos.index')->with('success', 'Serviço excluído com sucesso.');
    }

    public function listForClient(Request $request)
    {
        $query = Servico::query();

        if ($request->filled('busca')) {
            $query->where('nome', 'like', '%' . $request->busca . '%');
        }

        $servicos = $query->orderBy('nome')->paginate(10)->withQueryString();

        return view('servicos.list-cliente', compact('servicos'));
    }

    public function createForClient()
    {
        $servico = new Servico();
        return view('servicos.form-cliente', compact('servico'));
    }

    public function storeForClient(Request $request)
    {
        $dados = $this->prepareServicoData($request);

        Servico::create($dados);

        return redirect()->route('servicos.listForClient')->with('success', 'Serviço cadastrado com sucesso.');
    }

    public function editForClient(Servico $servico)
    {
        return view('servicos.form-cliente', compact('servico'));
    }

    public function updateForClient(Request $request, Servico $servico)
    {
        $dados = $this->prepareServicoData($request, $servico);

        $servico->update($dados);

        return redirect()->route('servicos.listForClient')->with('success', 'Serviço atualizado com sucesso.');
    }

    public function destroyForClient(Servico $servico)
    {
        $this->deleteImagem($servico);

        $servico->delete();

        return redirect()->route('servicos.listForClient')->with('success', 'Serviço excluído com sucesso.');
    }

    protected function prepareServicoData(Request $request, ?Servico $servico = null): array
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:250',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'duracao' => 'required|integer|min:1',
            'imagem' => 'nullable|image|max:2048',
        ]);

        $dados = collect($validated)->except('imagem')->toArray();

        if ($request->hasFile('imagem')) {
            if ($servico && $servico->imagem_path) {
                Storage::disk('public')->delete($servico->imagem_path);
            }

            $dados['imagem_path'] = $request->file('imagem')->store('servicos', 'public');
        }

        return $dados;
    }

    protected function deleteImagem(Servico $servico): void
    {
        if ($servico->imagem_path) {
            Storage::disk('public')->delete($servico->imagem_path);
        }
    }
}
