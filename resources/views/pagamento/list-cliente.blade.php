@extends('layouts.base')

@section('title', 'Meus Pagamentos')

@section('content')
    <h1 class="mb-3">Meus Pagamentos</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="mb-3 d-flex gap-2">
                <a href="{{ route('pagamentos.createForClient') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Novo Pagamento
                </a>
                @if($pagamentos->count() > 0)
                    <a href="{{ route('pagamentos.generatePdfForClient') }}" class="btn btn-primary" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Gerar Relatório PDF
                    </a>
                @endif
            </div>

            @if($pagamentos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Agendamento</th>
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
                                    <td>#{{ $pagamento->agendamento_id }}</td>
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
                                        <a href="{{ route('pagamentos.editForClient', $pagamento->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <form action="{{ route('pagamentos.destroyForClient', $pagamento->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este pagamento?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Excluir
                                            </button>
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
                    <p>Você ainda não possui nenhum pagamento registrado.</p>
                    <a href="{{ route('pagamentos.createForClient') }}" class="btn btn-success mt-2">
                        <i class="bi bi-plus-lg"></i> Registrar Primeiro Pagamento
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
