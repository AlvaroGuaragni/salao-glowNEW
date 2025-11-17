@extends('layouts.base')

@section('title', 'Lista de Serviços')

@section('content')
    <h1 class="mb-3">Lista de Serviços</h1>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('servicos.index') }}" class="d-flex gap-2 mb-3">
                <input type="text" name="busca" class="form-control" value="{{ request('busca') }}" placeholder="Buscar por nome ou descrição...">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ route('servicos.index') }}" class="btn btn-warning">Limpar</a>
            </form>

            <div class="mb-3">
                <a href="{{ route('servicos.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Novo Serviço
                </a>
            </div>

            @if($servicos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Duração (min)</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($servicos as $servico)
                                <tr>
                                    <td>{{ $servico->id }}</td>
                                    <td>
                                        @if($servico->imagem_path)
                                            <img src="{{ Storage::url($servico->imagem_path) }}" alt="{{ $servico->nome }}" class="rounded" style="width: 64px; height: 64px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $servico->nome }}</td>
                                    <td>{{ $servico->descricao ?? '-' }}</td>
                                    <td>R$ {{ number_format($servico->preco, 2, ',', '.') }}</td>
                                    <td>{{ $servico->duracao }}</td>
                                    <td>
                                        <a href="{{ route('servicos.edit', $servico->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('servicos.destroy', $servico->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este serviço?');">
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
                    <p>Nenhum serviço encontrado.</p>
                </div>
            @endif
        </div>
    </div>
@endsection