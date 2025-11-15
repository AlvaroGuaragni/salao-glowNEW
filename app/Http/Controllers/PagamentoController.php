<?php
namespace App\Http\Controllers;
use App\Models\Pagamento;
use App\Models\Agendamento;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function index(Request $request)
    {
        $pagamentos = Pagamento::with(['agendamento.cliente', 'agendamento.servico'])->paginate(15);
        return view('pagamento.list', compact('pagamentos'));
    }

    public function create()
    {
        $pagamento = new Pagamento();
        $agendamentos = Agendamento::with(['cliente', 'servico'])->where('status', '!=', 'pago')->get();
        return view('pagamento.form', compact('pagamento', 'agendamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agendamento_id' => 'required|exists:agendamentos,id',
            'valor' => 'required|numeric|min:0',
            'metodo' => 'required|string',
            'status' => 'required|string',
        ]);
        Pagamento::create($request->all());
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento registrado.');
    }

    public function edit(Pagamento $pagamento)
    {
        $agendamentos = Agendamento::with(['cliente', 'servico'])->get();
        return view('pagamento.form', compact('pagamento', 'agendamentos'));
    }

    public function update(Request $request, Pagamento $pagamento)
    {
        $request->validate([
            'agendamento_id' => 'required|exists:agendamentos,id',
            'valor' => 'required|numeric|min:0',
            'metodo' => 'required|string',
            'status' => 'required|string',
        ]);
        $pagamento->update($request->all());
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento atualizado.');
    }

    public function destroy(Pagamento $pagamento)
    {
        $pagamento->delete();
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento excluído.');
    }

    public function listForClient(Request $request)
    {
        $clienteId = Auth::user()->cliente->id;
        $pagamentos = Pagamento::with('agendamento.servico')
            ->whereHas('agendamento', function ($query) use ($clienteId) {
                $query->where('cliente_id', $clienteId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('pagamento.list-cliente', compact('pagamentos'));
    }
}