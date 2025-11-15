<?php
namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    public function index(Request $request)
    {
        $agendamentos = Agendamento::with(['cliente', 'servico'])->paginate(15);
        return view('agendamento.list', compact('agendamentos'));
    }

    public function create()
    {
        $agendamento = new Agendamento();
        $clientes = Cliente::orderBy('nome')->get(); 
        $servicos = Servico::orderBy('nome')->get();
        return view('agendamento.form', compact('agendamento', 'clientes', 'servicos'));
    }

    public function edit(Agendamento $agendamento)
    {
        $clientes = Cliente::orderBy('nome')->get(); 
        $servicos = Servico::orderBy('nome')->get();
        return view('agendamento.form', compact('agendamento', 'clientes', 'servicos'));
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servico_id' => 'required|exists:servicos,id',
            'data_hora' => 'required|date',
            'status' => 'required|string',
        ]);
        $agendamento->update($request->all());
        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado.');
    }

    public function destroy(Agendamento $agendamento)
    {
        $agendamento->delete();
        return redirect()->route('agendamentos.index')->with('success', 'Agendamento excluído.');
    }
    public function createForClient()
    {
        $servicos = Servico::orderBy('nome')->get();
        
        return view('agendamento.form-cliente', compact('servicos')); 
    }

    public function store(Request $request)
    {
        $dados = $request->all();

        if (empty($dados['cliente_id'])) {
            $dados['cliente_id'] = Auth::user()->cliente->id; 
        }

        if (empty($dados['status'])) {
            $dados['status'] = 'agendado'; 
        }

        $request->merge($dados); 
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servico_id' => 'required|exists:servicos,id',
            'data_hora' => 'required|date',
            'status' => 'required|string',
        ]);

        Agendamento::create($dados);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado com sucesso.');
        }

        return redirect()->route('dashboard')->with('success', 'Seu agendamento foi realizado com sucesso!');
    }
}