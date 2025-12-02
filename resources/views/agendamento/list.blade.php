@extends('layouts.base') {{-- Corrigido de 'base' para 'layouts.base' --}}

@section('title', 'Lista de Agendamentos')

@section('content')
    <h1 class="mb-3">Lista de Agendamentos</h1>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('agendamentos.index') }}" class="d-flex gap-2 mb-3">
                <input type="text" name="busca" class="form-control" value="{{ request('busca') }}" placeholder="Buscar por cliente, serviço ou status...">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ route('agendamentos.index') }}" class="btn btn-warning">Limpar</a>
            </form>

            <div class="mb-3">
                <a href="{{ route('agendamentos.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Novo Agendamento
                </a>
            </div>

            @if($agendamentos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Serviço</th>
                                <th>Data/Hora</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agendamentos as $agendamento)
                                <tr>
                                    <td>{{ $agendamento->id }}</td>
                                    <td>{{ $agendamento->cliente->nome ?? '-' }}</td>
                                    <td>
                                        @forelse($agendamento->servicos as $servico)
                                            <span class="badge bg-info">{{ $servico->nome }}</span>
                                        @empty
                                            -
                                        @endforelse
                                    </td>
                                    <td>{{ $agendamento->data_hora ? \Carbon\Carbon::parse($agendamento->data_hora)->format('d/m/Y H:i') : '-' }}</td>
                                    <td>{{ $agendamento->status }}</td>
                                    <td>
                                        <a href="{{ route('agendamentos.edit', $agendamento->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center p-4 text-muted">
                    <p>Nenhum agendamento encontrado.</p>
                </div>
            @endif
        </div>
    </div>
@endsection