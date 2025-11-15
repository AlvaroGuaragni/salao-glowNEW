@extends('layouts.base')

@section('title', 'Serviços Disponíveis')

@section('content')
    <h1 class="mb-3">Serviços Disponíveis</h1>

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
            <!-- Botão Novo Serviço -->
            <div class="mb-3">
                <a href="{{ route('servicos.createForClient') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Novo Serviço
                </a>
            </div>

            <form method="GET" action="{{ route('servicos.listForClient') }}" class="d-flex gap-2 mb-3">
                <input type="text" name="busca" class="form-control" value="{{ request('busca') }}" placeholder="Buscar por nome do serviço...">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ route('servicos.listForClient') }}" class="btn btn-warning">Limpar</a>
            </form>

            @if($servicos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Serviço</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Duração (min)</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servicos as $servico)
                                <tr>
                                    <td>{{ $servico->nome }}</td>
                                    <td>{{ $servico->descricao ?? '-' }}</td>
                                    <td>R$ {{ number_format($servico->preco, 2, ',', '.') }}</td>
                                    <td>{{ $servico->duracao }} min</td>
                                    <td>
                                        <a href="{{ route('servicos.editForClient', $servico->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                        <form action="{{ route('servicos.destroyForClient', $servico->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este serviço?');">
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
                    {{ $servicos->links() }}
                </div>
            @else
                <div class="text-center p-4 text-muted">
                    <p>Nenhum serviço encontrado.</p>
                    <a href="{{ route('servicos.createForClient') }}" class="btn btn-success mt-2">
                        <i class="bi bi-plus-lg"></i> Registrar Primeiro Serviço
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
