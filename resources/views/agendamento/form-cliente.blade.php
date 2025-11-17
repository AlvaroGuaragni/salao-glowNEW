@extends('layouts.base')

@section('title', isset($agendamento) ? 'Editar Agendamento' : 'Novo Agendamento')

@section('content')
    <h1 class="mb-3">{{ isset($agendamento) ? 'Editar Agendamento' : 'Novo Agendamento' }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($agendamento) ? route('agendamentos.updateForClient', $agendamento) : route('agendamentos.store') }}" method="POST">
                @csrf
                @if(isset($agendamento))
                    @method('PUT')
                @endif
                
                <div class="mb-3">
                    <label for="servico_id" class="form-label">Qual serviço você deseja? *</label>
                    <select id="servico_id" name="servico_id" class="form-select @error('servico_id') is-invalid @enderror" required>
                        <option value="">Selecione um serviço</option>
                        @foreach($servicos as $servico)
                            <option value="{{ $servico->id }}" {{ old('servico_id', isset($agendamento) ? $agendamento->servico_id : null) == $servico->id ? 'selected' : '' }}>
                                {{ $servico->nome }} - R$ {{ number_format($servico->preco, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('servico_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="data_hora" class="form-label">Qual a data e hora? *</label>
                    <input 
                        type="datetime-local" 
                        id="data_hora" 
                        name="data_hora" 
                        class="form-control @error('data_hora') is-invalid @enderror" 
                        value="{{ old('data_hora', isset($agendamento) && $agendamento->data_hora ? \Carbon\Carbon::parse($agendamento->data_hora)->format('Y-m-d\TH:i') : null) }}" 
                        required
                    >
                    @error('data_hora')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        {{ isset($agendamento) ? 'Salvar Alterações' : 'Confirmar Agendamento' }}
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
