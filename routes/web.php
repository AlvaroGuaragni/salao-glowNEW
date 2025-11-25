<?php

use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServicoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Agendamento; 

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    if ($request->user()->role === 'admin') {
        return redirect()->route('clientes.index');
    }
    
    $cliente = $request->user()->cliente;
    if (!$cliente) {
        return redirect()->route('profile.edit')->with('error', 'Complete seu perfil para continuar.');
    }
    
    $agendamentosQuery = Agendamento::with('servico')
        ->where('cliente_id', $cliente->id);

    if ($request->filled('busca')) {
        $busca = $request->busca;
        $agendamentosQuery->where(function ($q) use ($busca) {
            $q->where('status', 'like', '%' . $busca . '%')
                ->orWhereDate('data_hora', $busca)
                ->orWhereHas('servico', function ($sub) use ($busca) {
                    $sub->where('nome', 'like', '%' . $busca . '%');
                });
        });
    }

    $agendamentos = $agendamentosQuery
        ->orderBy('data_hora', 'desc')
        ->get();
    
    return view('dashboard', compact('agendamentos'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
 
    Route::get('/meus-agendamentos/novo', [AgendamentoController::class, 'createForClient'])->name('agendamentos.createForClient');
    Route::get('/meus-agendamentos/{agendamento}/editar', [AgendamentoController::class, 'editForClient'])->name('agendamentos.editForClient');
    Route::put('/meus-agendamentos/{agendamento}', [AgendamentoController::class, 'updateForClient'])->name('agendamentos.updateForClient');
    Route::delete('/meus-agendamentos/{agendamento}', [AgendamentoController::class, 'destroyForClient'])->name('agendamentos.destroyForClient');
    

    Route::get('/servicos-disponiveis', [ServicoController::class, 'listForClient'])->name('servicos.listForClient');
    Route::get('/servicos-disponiveis/novo', [ServicoController::class, 'createForClient'])->name('servicos.createForClient');
    Route::post('/servicos-disponiveis', [ServicoController::class, 'storeForClient'])->name('servicos.storeForClient');
    Route::get('/servicos-disponiveis/{servico}/editar', [ServicoController::class, 'editForClient'])->name('servicos.editForClient');
    Route::put('/servicos-disponiveis/{servico}', [ServicoController::class, 'updateForClient'])->name('servicos.updateForClient');
    Route::delete('/servicos-disponiveis/{servico}', [ServicoController::class, 'destroyForClient'])->name('servicos.destroyForClient');
    
    Route::get('/meus-pagamentos', [PagamentoController::class, 'listForClient'])->name('pagamentos.listForClient');
    Route::get('/meus-pagamentos/novo', [PagamentoController::class, 'createForClient'])->name('pagamentos.createForClient');
    Route::post('/meus-pagamentos', [PagamentoController::class, 'storeForClient'])->name('pagamentos.storeForClient');
    Route::get('/meus-pagamentos/{pagamento}/editar', [PagamentoController::class, 'editForClient'])->name('pagamentos.editForClient');
    Route::put('/meus-pagamentos/{pagamento}', [PagamentoController::class, 'updateForClient'])->name('pagamentos.updateForClient');
    Route::delete('/meus-pagamentos/{pagamento}', [PagamentoController::class, 'destroyForClient'])->name('pagamentos.destroyForClient');
    Route::get('/meus-pagamentos/relatorio/pdf', [PagamentoController::class, 'generatePdfForClient'])->name('pagamentos.generatePdfForClient');

    Route::post('/agendamentos', [AgendamentoController::class, 'store'])->name('agendamentos.store');
    
    Route::get('/servicos/relatorio/pdf', [ServicoController::class, 'relatorioPdf'])->name('servicos.relatorioPdf');
    
    Route::middleware('admin')->group(function () {
        
        Route::resource('clientes', ClienteController::class);
        Route::resource('servicos', ServicoController::class);
        
        Route::resource('agendamentos', AgendamentoController::class)->except(['store']); 
        
        Route::resource('pagamentos', PagamentoController::class);
    });
});

require __DIR__.'/auth.php';