<?php
namespace App\Http\Controllers;
use App\Models\Pagamento;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Dompdf\Dompdf;
use Dompdf\Options;

class PagamentoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pagamento::with(['agendamento.cliente', 'agendamento.servico']);
        
        if ($request->has('busca') && !empty($request->busca)) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->whereHas('agendamento', function($q) use ($busca) {
                    $q->whereHas('cliente', function($q) use ($busca) {
                        $q->where('nome', 'like', '%' . $busca . '%');
                    })->orWhereHas('servico', function($q) use ($busca) {
                        $q->where('nome', 'like', '%' . $busca . '%');
                    });
                })
                ->orWhere('metodo', 'like', '%' . $busca . '%')
                ->orWhere('status', 'like', '%' . $busca . '%');
            });
        }
        
        $pagamentos = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('pagamento.list', compact('pagamentos'));
    }

    public function create()
    {
        $pagamento = new Pagamento();
        // Buscar agendamentos que ainda não têm pagamento registrado
        $agendamentos = Agendamento::with(['cliente', 'servico'])
            ->whereDoesntHave('pagamento')
            ->orderBy('data_hora', 'desc')
            ->get();
        return view('pagamento.form', compact('pagamento', 'agendamentos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agendamento_id' => 'required|exists:agendamentos,id',
            'valor' => 'required|numeric|min:0.01',
            'metodo' => 'required|string|in:dinheiro,cartao_debito,cartao_credito,pix,transferencia',
            'status' => 'required|string|in:pendente,pago,cancelado,reembolsado',
            'comprovante' => 'nullable|image|max:4096',
        ]);
        
        // Verificar se o agendamento já tem pagamento
        $pagamentoExistente = Pagamento::where('agendamento_id', $validated['agendamento_id'])->first();
        if ($pagamentoExistente) {
            return back()->with('error', 'Este agendamento já possui um pagamento registrado.')->withInput();
        }
        
        $dados = $this->buildPagamentoData($request, $validated);

        Pagamento::create($dados);
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento registrado com sucesso.');
    }

    public function edit(Pagamento $pagamento)
    {
        $agendamentos = Agendamento::with(['cliente', 'servico'])->get();
        return view('pagamento.form', compact('pagamento', 'agendamentos'));
    }

    public function update(Request $request, Pagamento $pagamento)
    {
        $validated = $request->validate([
            'agendamento_id' => 'required|exists:agendamentos,id',
            'valor' => 'required|numeric|min:0.01',
            'metodo' => 'required|string|in:dinheiro,cartao_debito,cartao_credito,pix,transferencia',
            'status' => 'required|string|in:pendente,pago,cancelado,reembolsado',
            'comprovante' => 'nullable|image|max:4096',
        ]);
        
        // Verificar se outro pagamento já existe para este agendamento
        $pagamentoExistente = Pagamento::where('agendamento_id', $validated['agendamento_id'])
            ->where('id', '!=', $pagamento->id)
            ->first();
        if ($pagamentoExistente) {
            return back()->with('error', 'Este agendamento já possui outro pagamento registrado.')->withInput();
        }
        
        $dados = $this->buildPagamentoData($request, $validated, $pagamento);

        $pagamento->update($dados);
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento atualizado com sucesso.');
    }

    public function destroy(Pagamento $pagamento)
    {
        $this->deleteComprovante($pagamento);

        $pagamento->delete();
        return redirect()->route('pagamentos.index')->with('success', 'Pagamento excluído.');
    }

    public function listForClient(Request $request)
    {
        $cliente = Auth::user()->cliente;
        if (!$cliente) {
            return back()->with('error', 'Cliente não encontrado. Complete seu perfil para continuar.');
        }

        $query = Pagamento::with('agendamento.servico')
            ->whereHas('agendamento', function ($sub) use ($cliente) {
                $sub->where('cliente_id', $cliente->id);
            });

        if ($request->filled('busca')) {
            $busca = $request->busca;
            $query->where(function ($q) use ($busca) {
                $q->where('metodo', 'like', '%' . $busca . '%')
                    ->orWhere('status', 'like', '%' . $busca . '%')
                    ->orWhereHas('agendamento', function ($agendamentoQuery) use ($busca) {
                        $agendamentoQuery
                            ->where('id', $busca)
                            ->orWhereHas('servico', function ($servicoQuery) use ($busca) {
                                $servicoQuery->where('nome', 'like', '%' . $busca . '%');
                            });
                    });
            });
        }
        
        $pagamentos = $query
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
        return view('pagamento.list-cliente', compact('pagamentos'));
    }

    public function createForClient()
    {
        $cliente = Auth::user()->cliente;
        if (!$cliente) {
            return back()->with('error', 'Cliente não encontrado. Complete seu perfil para continuar.');
        }

        $pagamento = new Pagamento();
        // Buscar agendamentos do cliente que ainda não têm pagamento registrado
        $agendamentos = Agendamento::with(['cliente', 'servico'])
            ->where('cliente_id', $cliente->id)
            ->whereDoesntHave('pagamento')
            ->orderBy('data_hora', 'desc')
            ->get();
        return view('pagamento.form-cliente', compact('pagamento', 'agendamentos'));
    }

    public function storeForClient(Request $request)
    {
        $cliente = Auth::user()->cliente;
        if (!$cliente) {
            return back()->with('error', 'Cliente não encontrado. Complete seu perfil para continuar.');
        }

        $validated = $request->validate([
            'agendamento_id' => 'required|exists:agendamentos,id',
            'valor' => 'required|numeric|min:0.01',
            'metodo' => 'required|string|in:dinheiro,cartao_debito,cartao_credito,pix,transferencia',
            'status' => 'required|string|in:pendente,pago,cancelado,reembolsado',
            'comprovante' => 'nullable|image|max:4096',
        ]);

        // Verificar se o agendamento pertence ao cliente
        $agendamento = Agendamento::findOrFail($validated['agendamento_id']);
        if ($agendamento->cliente_id != $cliente->id) {
            return back()->with('error', 'Você não tem permissão para criar pagamento para este agendamento.')->withInput();
        }
        
        // Verificar se o agendamento já tem pagamento
        $pagamentoExistente = Pagamento::where('agendamento_id', $validated['agendamento_id'])->first();
        if ($pagamentoExistente) {
            return back()->with('error', 'Este agendamento já possui um pagamento registrado.')->withInput();
        }
        
        $dados = $this->buildPagamentoData($request, $validated);

        Pagamento::create($dados);
        return redirect()->route('pagamentos.listForClient')->with('success', 'Pagamento registrado com sucesso.');
    }

    public function editForClient(Pagamento $pagamento)
    {
        $cliente = Auth::user()->cliente;
        if (!$cliente) {
            return back()->with('error', 'Cliente não encontrado. Complete seu perfil para continuar.');
        }

        // Verificar se o pagamento pertence ao cliente
        if ($pagamento->agendamento->cliente_id != $cliente->id) {
            return back()->with('error', 'Você não tem permissão para editar este pagamento.');
        }

        // Buscar agendamentos do cliente
        $agendamentos = Agendamento::with(['cliente', 'servico'])
            ->where('cliente_id', $cliente->id)
            ->orderBy('data_hora', 'desc')
            ->get();
        return view('pagamento.form-cliente', compact('pagamento', 'agendamentos'));
    }

    public function updateForClient(Request $request, Pagamento $pagamento)
    {
        $cliente = Auth::user()->cliente;
        if (!$cliente) {
            return back()->with('error', 'Cliente não encontrado. Complete seu perfil para continuar.');
        }

        // Verificar se o pagamento pertence ao cliente
        if ($pagamento->agendamento->cliente_id != $cliente->id) {
            return back()->with('error', 'Você não tem permissão para editar este pagamento.');
        }

        $validated = $request->validate([
            'agendamento_id' => 'required|exists:agendamentos,id',
            'valor' => 'required|numeric|min:0.01',
            'metodo' => 'required|string|in:dinheiro,cartao_debito,cartao_credito,pix,transferencia',
            'status' => 'required|string|in:pendente,pago,cancelado,reembolsado',
            'comprovante' => 'nullable|image|max:4096',
        ]);

        // Verificar se o agendamento pertence ao cliente
        $agendamento = Agendamento::findOrFail($validated['agendamento_id']);
        if ($agendamento->cliente_id != $cliente->id) {
            return back()->with('error', 'Você não tem permissão para associar este agendamento.')->withInput();
        }
        
        // Verificar se outro pagamento já existe para este agendamento
        $pagamentoExistente = Pagamento::where('agendamento_id', $validated['agendamento_id'])
            ->where('id', '!=', $pagamento->id)
            ->first();
        if ($pagamentoExistente) {
            return back()->with('error', 'Este agendamento já possui outro pagamento registrado.')->withInput();
        }
        
        $dados = $this->buildPagamentoData($request, $validated, $pagamento);

        $pagamento->update($dados);
        return redirect()->route('pagamentos.listForClient')->with('success', 'Pagamento atualizado com sucesso.');
    }

    public function destroyForClient(Pagamento $pagamento)
    {
        $cliente = Auth::user()->cliente;
        if (!$cliente) {
            return back()->with('error', 'Cliente não encontrado. Complete seu perfil para continuar.');
        }

        // Verificar se o pagamento pertence ao cliente
        if ($pagamento->agendamento->cliente_id != $cliente->id) {
            return back()->with('error', 'Você não tem permissão para excluir este pagamento.');
        }

        $this->deleteComprovante($pagamento);

        $pagamento->delete();
        return redirect()->route('pagamentos.listForClient')->with('success', 'Pagamento excluído com sucesso.');
    }

    public function generatePdfForClient()
    {
        $cliente = Auth::user()->cliente;
        if (!$cliente) {
            return back()->with('error', 'Cliente não encontrado. Complete seu perfil para continuar.');
        }

        // Buscar todos os pagamentos do cliente
        $pagamentos = Pagamento::with('agendamento.servico')
            ->whereHas('agendamento', function ($query) use ($cliente) {
                $query->where('cliente_id', $cliente->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Calcular totais
        $totalGeral = $pagamentos->sum('valor');
        $totalPago = $pagamentos->where('status', 'pago')->sum('valor');
        $totalPendente = $pagamentos->where('status', 'pendente')->sum('valor');

        // Configurar opções do dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        // Renderizar a view
        $html = view('pagamento.pdf-cliente', compact('pagamentos', 'cliente', 'totalGeral', 'totalPago', 'totalPendente'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Nome do arquivo
        $filename = 'relatorio_pagamentos_' . date('Y-m-d_His') . '.pdf';

        // Retornar o PDF para download
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    protected function buildPagamentoData(Request $request, array $validated, ?Pagamento $pagamento = null): array
    {
        $dados = collect($validated)->except('comprovante')->toArray();

        if ($request->hasFile('comprovante')) {
            if ($pagamento && $pagamento->comprovante_path) {
                Storage::disk('public')->delete($pagamento->comprovante_path);
            }

            $dados['comprovante_path'] = $request->file('comprovante')->store('pagamentos', 'public');
        }

        return $dados;
    }

    protected function deleteComprovante(Pagamento $pagamento): void
    {
        if ($pagamento->comprovante_path) {
            Storage::disk('public')->delete($pagamento->comprovante_path);
        }
    }
}