@extends('layouts.base')

@section('title', 'Meus Agendamentos')

@section('content')
    <h1 class="mb-3">Meus Agendamentos</h1>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('agendamentos.createForClient') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Novo Agendamento
                </a>
            </div>

            <form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2 mb-3">
                <input 
                    type="text" 
                    name="busca" 
                    class="form-control" 
                    value="{{ request('busca') }}" 
                    placeholder="Buscar por serviço, status ou data (YYYY-MM-DD)..."
                >
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ route('dashboard') }}" class="btn btn-warning">Limpar</a>
            </form>

            @if($agendamentos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Serviço</th>
                                <th>Data / Hora</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agendamentos as $agendamento)
                                <tr>
                                    <td>
                                        @forelse($agendamento->servicos as $servico)
                                            <span class="badge bg-primary">{{ $servico->nome }}</span>
                                        @empty
                                            Serviço excluído
                                        @endforelse
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($agendamento->data_hora)->format('d/m/Y \à\s H:i') }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($agendamento->status) }}</span></td>
                                    <td class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('agendamentos.editForClient', $agendamento->id) }}" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>
                                        <form action="{{ route('agendamentos.destroyForClient', $agendamento->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja cancelar este agendamento?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center p-4 text-muted">
                    <p>Você ainda não possui nenhum agendamento.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
