@extends('layouts.base')

@section('title', 'Lista de Pagamentos')

@section('content')
    <h1 class="mb-3">Lista de Pagamentos</h1>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('pagamentos.index') }}" class="d-flex gap-2 mb-3">
                <input type="text" name="busca" class="form-control" value="{{ request('busca') }}" placeholder="Buscar por cliente, serviço, método ou status...">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ route('pagamentos.index') }}" class="btn btn-warning">Limpar</a>
            </form>

            <div class="mb-3">
                <a href="{{ route('pagamentos.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Novo Pagamento
                </a>
            </div>

            @if($pagamentos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Agendamento</th>
                                <th>Cliente</th>
                                <th>Serviço</th>
                                <th>Valor</th>
                                <th>Método</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagamentos as $pagamento)
                                <tr>
                                    <td>{{ $pagamento->id }}</td>
                                    <td>#{{ $pagamento->agendamento_id }}</td>
                                    <td>{{ $pagamento->agendamento->cliente->nome ?? '-' }}</td>
                                    <td>{{ $pagamento->agendamento->servico->nome ?? '-' }}</td>
                                    <td>R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $pagamento->metodo)) }}</td>
                                    <td>
                                        @if($pagamento->status == 'pago')
                                            <span class="badge bg-success">{{ ucfirst($pagamento->status) }}</span>
                                        @elseif($pagamento->status == 'pendente')
                                            <span class="badge bg-warning">{{ ucfirst($pagamento->status) }}</span>
                                        @elseif($pagamento->status == 'cancelado')
                                            <span class="badge bg-danger">{{ ucfirst($pagamento->status) }}</span>
                                        @elseif($pagamento->status == 'reembolsado')
                                            <span class="badge bg-secondary">{{ ucfirst($pagamento->status) }}</span>
                                        @else
                                            <span class="badge bg-info">{{ ucfirst($pagamento->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pagamentos.edit', $pagamento->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('pagamentos.destroy', $pagamento->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este pagamento?');">
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
                
                <div class="mt-3">
                    {{ $pagamentos->links() }}
                </div>
            @else
                <div class="text-center p-4 text-muted">
                    <p>Nenhum pagamento encontrado.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
