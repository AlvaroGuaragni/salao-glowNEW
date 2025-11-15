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
    
    $agendamentos = Agendamento::with('servico')
        ->where('cliente_id', $request->user()->cliente->id)
        ->orderBy('data_hora', 'desc')
        ->get();
    
    return view('dashboard', compact('agendamentos'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
 
    Route::get('/meus-agendamentos/novo', [AgendamentoController::class, 'createForClient'])->name('agendamentos.createForClient');
    

    Route::get('/servicos-disponiveis', [ServicoController::class, 'listForClient'])->name('servicos.listForClient');
    
    Route::get('/meus-pagamentos', [PagamentoController::class, 'listForClient'])->name('pagamentos.listForClient');

    Route::post('/agendamentos', [AgendamentoController::class, 'store'])->name('agendamentos.store');
    
    
    Route::middleware('admin')->group(function () {
        
        Route::resource('clientes', ClienteController::class);
        Route::resource('servicos', ServicoController::class);
        
        Route::resource('agendamentos', AgendamentoController::class)->except(['store']); 
        
        Route::resource('pagamentos', PagamentoController::class);
    });
});

require __DIR__.'/auth.php';