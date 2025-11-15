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

            @if($agendamentos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Serviço</th>
                                <th>Data / Hora</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agendamentos as $agendamento)
                                <tr>
                                    <td>{{ $agendamento->servico->nome ?? 'Serviço excluído' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($agendamento->data_hora)->format('d/m/Y \à\s H:i') }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($agendamento->status) }}</span></td>
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
