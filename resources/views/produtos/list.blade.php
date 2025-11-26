@extends('layouts.base')

@section('title', 'Lista de Produtos')

@section('content')
    <h1 class="mb-3">Lista de Produtos</h1>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('produtos.index') }}" class="d-flex gap-2 mb-3">
                <input type="text" name="busca" class="form-control" value="{{ request('busca') }}" placeholder="Buscar por nome ou marca...">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ route('produtos.index') }}" class="btn btn-warning">Limpar</a>
            </form>

            <div class="mb-3">
                <a href="{{ route('produtos.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Novo Produto
                </a>
            </div>

            @if($produtos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Marca</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produtos as $produto)
                                <tr>
                                    <td>{{ $produto->id }}</td>
                                    <td>{{ $produto->nome }}</td>
                                    <td>{{ $produto->marca ?? '-' }}</td>
                                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $produto->estoque > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $produto->estoque }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
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
                    <p>Nenhum produto encontrado.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
