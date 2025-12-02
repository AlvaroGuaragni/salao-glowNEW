@extends('layouts.base')

@section('title', isset($agendamento->id) ? 'Editar Agendamento' : 'Novo Agendamento')

@section('content')
    <h1 class="mb-3">{{ isset($agendamento->id) ? 'Editar Agendamento' : 'Novo Agendamento' }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($agendamento->id) ? route('agendamentos.update', $agendamento->id) : route('agendamentos.store') }}" method="POST">
                @csrf
                @if(isset($agendamento->id))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="cliente_id" class="form-label">Cliente *</label>
                    <select id="cliente_id" name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id', $agendamento->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nome }} - {{ $cliente->cpf }}
                            </option>
                        @endforeach
                    </select>
                    @error('cliente_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="servico_ids" class="form-label">Serviços * (selecione um ou mais)</label>
                    <select id="servico_ids" name="servico_ids[]" class="form-select @error('servico_ids') is-invalid @enderror" multiple required>
                        @foreach($servicos as $servico)
                            <option value="{{ $servico->id }}" 
                                @if(isset($agendamento) && isset($agendamento->id) && $agendamento->servicos->contains($servico->id))
                                    selected
                                @elseif(is_array(old('servico_ids')) && in_array($servico->id, old('servico_ids')))
                                    selected
                                @endif
                            >
                                {{ $servico->nome }} - R$ {{ number_format($servico->preco, 2, ',', '.') }} ({{ $servico->duracao }} min)
                            </option>
                        @endforeach
                    </select>
                    @error('servico_ids')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Use Ctrl+Click (ou Cmd+Click no Mac) para selecionar múltiplos serviços</small>
                </div>

                <div class="mb-3">
                    <label for="data_hora" class="form-label">Data e Hora *</label>
                    <input type="datetime-local" id="data_hora" name="data_hora" class="form-control @error('data_hora') is-invalid @enderror" value="{{ old('data_hora', $agendamento->data_hora ? \Carbon\Carbon::parse($agendamento->data_hora)->format('Y-m-d\\TH:i') : '') }}" required>
                    @error('data_hora')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="">Selecione um status</option>
                        <option value="agendado" {{ old('status', $agendamento->status) == 'agendado' ? 'selected' : '' }}>Agendado</option>
                        <option value="confirmado" {{ old('status', $agendamento->status) == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                        <option value="em_andamento" {{ old('status', $agendamento->status) == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="concluido" {{ old('status', $agendamento->status) == 'concluido' ? 'selected' : '' }}>Concluído</option>
                        <option value="cancelado" {{ old('status', $agendamento->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">{{ isset($agendamento->id) ? 'Atualizar' : 'Cadastrar' }}</button>
                    <a href="{{ route('agendamentos.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
