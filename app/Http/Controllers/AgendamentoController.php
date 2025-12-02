<?php
namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Servico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AgendamentoController extends Controller
{
    private const STATUS_OPTIONS = [
        'agendado',
        'confirmado',
        'em_andamento',
        'concluido',
        'cancelado',
    ];

    public function index(Request $request)
    {
        $query = Agendamento::with(['cliente', 'servicos'])->orderBy('data_hora', 'desc');

        if ($request->filled('busca')) {
            $busca = $request->busca;

            $query->where(function ($q) use ($busca) {
                $q->where('status', 'like', '%' . $busca . '%')
                    ->orWhereDate('data_hora', $busca)
                    ->orWhereHas('cliente', function ($sub) use ($busca) {
                        $sub->where('nome', 'like', '%' . $busca . '%')
                            ->orWhere('email', 'like', '%' . $busca . '%');
                    })
                    ->orWhereHas('servicos', function ($sub) use ($busca) {
                        $sub->where('nome', 'like', '%' . $busca . '%');
                    });
            });
        }

        $agendamentos = $query->paginate(15)->withQueryString();

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

    protected function ensureClientOwns(Agendamento $agendamento)
    {
        $cliente = Auth::user()->cliente;

        if (!$cliente || $agendamento->cliente_id !== $cliente->id) {
            abort(403, 'Você não tem permissão para acessar este agendamento.');
        }

        return $cliente;
    }

    public function update(Request $request, Agendamento $agendamento)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servico_ids' => 'required|array|min:1',
            'servico_ids.*' => 'required|exists:servicos,id',
            'data_hora' => 'required|date',
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
        ]);

        $agendamento->update([
            'cliente_id' => $request->cliente_id,
            'data_hora' => $request->data_hora,
            'status' => $request->status,
        ]);

        $agendamento->servicos()->sync($request->servico_ids);

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

    public function editForClient(Agendamento $agendamento)
    {
        $this->ensureClientOwns($agendamento);

        $servicos = Servico::orderBy('nome')->get();

        return view('agendamento.form-cliente', [
            'servicos' => $servicos,
            'agendamento' => $agendamento,
        ]);
    }

    public function store(Request $request)
    {
        $dados = $request->all();

        if (empty($dados['cliente_id'])) {
            $cliente = Auth::user()->cliente;
            if (!$cliente) {
                return back()->with('error', 'Cliente não encontrado. Complete seu perfil para continuar.')->withInput();
            }
            $dados['cliente_id'] = $cliente->id; 
        }

        if (empty($dados['status'])) {
            $dados['status'] = 'agendado'; 
        }

        $request->merge($dados); 
        
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servico_ids' => 'required|array|min:1',
            'servico_ids.*' => 'required|exists:servicos,id',
            'data_hora' => 'required|date|after:now',
            'status' => ['required', Rule::in(self::STATUS_OPTIONS)],
        ]);

        $agendamento = Agendamento::create([
            'cliente_id' => $dados['cliente_id'],
            'data_hora' => $dados['data_hora'],
            'status' => $dados['status'],
        ]);

        $agendamento->servicos()->attach($dados['servico_ids']);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado com sucesso.');
        }

        return redirect()->route('dashboard')->with('success', 'Seu agendamento foi realizado com sucesso!');
    }

    public function updateForClient(Request $request, Agendamento $agendamento)
    {
        $this->ensureClientOwns($agendamento);

        $dadosValidados = $request->validate([
            'servico_ids' => 'required|array|min:1',
            'servico_ids.*' => 'required|exists:servicos,id',
            'data_hora' => 'required|date|after:now',
        ]);

        $agendamento->update([
            'data_hora' => $dadosValidados['data_hora'],
        ]);

        $agendamento->servicos()->sync($dadosValidados['servico_ids']);

        return redirect()->route('dashboard')->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroyForClient(Agendamento $agendamento)
    {
        $this->ensureClientOwns($agendamento);

        $agendamento->delete();

        return redirect()->route('dashboard')->with('success', 'Agendamento cancelado com sucesso.');
    }
}