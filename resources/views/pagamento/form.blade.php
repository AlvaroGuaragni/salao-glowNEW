@extends('layouts.base')

@section('title', $pagamento->exists ? 'Editar Pagamento' : 'Novo Pagamento')

@section('content')
    <h1 class="mb-3">{{ $pagamento->exists ? 'Editar Pagamento' : 'Novo Pagamento' }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ $pagamento->exists ? route('pagamentos.update', $pagamento->id) : route('pagamentos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($pagamento->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="agendamento_id" class="form-label">Agendamento *</label>
                    <select id="agendamento_id" name="agendamento_id" class="form-select @error('agendamento_id') is-invalid @enderror" required>
                        <option value="">Selecione um agendamento</option>
                        @foreach($agendamentos as $agendamento)
                            <option value="{{ $agendamento->id }}" {{ old('agendamento_id', $pagamento->agendamento_id) == $agendamento->id ? 'selected' : '' }}>
                                #{{ $agendamento->id }} - {{ $agendamento->cliente->nome ?? '-' }} - {{ $agendamento->servico->nome ?? '-' }} 
                                @if($agendamento->data_hora)
                                    ({{ \Carbon\Carbon::parse($agendamento->data_hora)->format('d/m/Y H:i') }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('agendamento_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="valor" class="form-label">Valor (R$) *</label>
                    <input type="number" id="valor" name="valor" class="form-control @error('valor') is-invalid @enderror" step="0.01" min="0" value="{{ old('valor', $pagamento->valor ?? '') }}" required>
                    @error('valor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="metodo" class="form-label">Método de Pagamento *</label>
                    <select id="metodo" name="metodo" class="form-select @error('metodo') is-invalid @enderror" required>
                        <option value="">Selecione um método</option>
                        <option value="dinheiro" {{ old('metodo', $pagamento->metodo ?? '') == 'dinheiro' ? 'selected' : '' }}>Dinheiro</option>
                        <option value="cartao_debito" {{ old('metodo', $pagamento->metodo ?? '') == 'cartao_debito' ? 'selected' : '' }}>Cartão de Débito</option>
                        <option value="cartao_credito" {{ old('metodo', $pagamento->metodo ?? '') == 'cartao_credito' ? 'selected' : '' }}>Cartão de Crédito</option>
                        <option value="pix" {{ old('metodo', $pagamento->metodo ?? '') == 'pix' ? 'selected' : '' }}>PIX</option>
                        <option value="transferencia" {{ old('metodo', $pagamento->metodo ?? '') == 'transferencia' ? 'selected' : '' }}>Transferência</option>
                    </select>
                    @error('metodo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">Selecione um status</option>
                        <option value="pendente" {{ old('status', $pagamento->status ?? '') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="pago" {{ old('status', $pagamento->status ?? '') == 'pago' ? 'selected' : '' }}>Pago</option>
                        <option value="cancelado" {{ old('status', $pagamento->status ?? '') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        <option value="reembolsado" {{ old('status', $pagamento->status ?? '') == 'reembolsado' ? 'selected' : '' }}>Reembolsado</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="comprovante" class="form-label">Comprovante de Pagamento</label>
                    <input type="file" id="comprovante" name="comprovante" class="form-control @error('comprovante') is-invalid @enderror" accept="image/*">
                    @error('comprovante')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($pagamento->comprovante_path)
                        <div class="mt-2">
                            <p class="text-muted mb-1">Prévia:</p>
                            <img src="{{ Storage::url($pagamento->comprovante_path) }}" alt="Comprovante" class="rounded shadow-sm" style="max-width: 220px; height: auto;">
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">{{ $pagamento->exists ? 'Atualizar' : 'Cadastrar' }}</button>
                    <a href="{{ route('pagamentos.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
