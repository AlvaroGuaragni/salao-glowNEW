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
                    <select id="cliente_id" name="cliente_id" class="form-select" required>
                        <option value="">Selecione um cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id', $agendamento->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nome }} - {{ $cliente->cpf }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="servico_id" class="form-label">Serviço *</label>
                    <select id="servico_id" name="servico_id" class="form-select" required>
                        <option value="">Selecione um serviço</option>
                        @foreach($servicos as $servico)
                            <option value="{{ $servico->id }}" {{ old('servico_id', $agendamento->servico_id) == $servico->id ? 'selected' : '' }}>
                                {{ $servico->nome }} - R$ {{ number_format($servico->preco, 2, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="data_hora" class="form-label">Data e Hora *</label>
                    <input type="datetime-local" id="data_hora" name="data_hora" class="form-control" value="{{ old('data_hora', $agendamento->data_hora ? \Carbon\Carbon::parse($agendamento->data_hora)->format('Y-m-d\TH:i') : '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="">Selecione um status</option>
                        <option value="agendado" {{ old('status', $agendamento->status) == 'agendado' ? 'selected' : '' }}>Agendado</option>
                        <option value="confirmado" {{ old('status', $agendamento->status) == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                        <option value="em_andamento" {{ old('status', $agendamento->status) == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="concluido" {{ old('status', $agendamento->status) == 'concluido' ? 'selected' : '' }}>Concluído</option>
                        <option value="cancelado" {{ old('status', $agendamento->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">{{ isset($agendamento->id) ? 'Atualizar' : 'Cadastrar' }}</button>
                    <a href="{{ route('agendamentos.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
