@extends('layouts.base')

@section('title', 'Novo Agendamento')

@section('content')
    <h1 class="mb-3">Novo Agendamento</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('agendamentos.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="servico_id" class="form-label">Qual serviço você deseja? *</label>
                    <select id="servico_id" name="servico_id" class="form-select" required>
                        <option value="">Selecione um serviço</option>
                        @foreach($servicos as $servico)
                            <option value="{{ $servico->id }}" {{ old('servico_id') == $servico->id ? 'selected' : '' }}>
                                {{ $servico->nome }} - R$ {{ number_format($servico->preco, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="data_hora" class="form-label">Qual a data e hora? *</label>
                    <input type="datetime-local" id="data_hora" name="data_hora" class="form-control" value="{{ old('data_hora') }}" required>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Confirmar Agendamento</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
