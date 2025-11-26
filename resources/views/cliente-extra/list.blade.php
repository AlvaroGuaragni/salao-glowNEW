@extends('layouts.base')

@section('title', 'Lista de Clientes')

@section('content')
    <h1 class="mb-3">Lista de Clientes</h1>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('cliente-extra.index') }}" class="d-flex gap-2 mb-3">
                <input type="text" name="busca" class="form-control" value="{{ request('busca') }}" placeholder="Buscar por nome, email ou telefone...">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ route('cliente-extra.index') }}" class="btn btn-warning">Limpar</a>
            </form>

            <div class="mb-3">
                <a href="{{ route('cliente-extra.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Novo Cliente
                </a>
            </div>

            @if($clientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Cidade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->nome }}</td>
                                    <td>{{ $cliente->email }}</td>
                                    <td>{{ $cliente->telefone ?? '-' }}</td>
                                    <td>{{ $cliente->cidade ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('cliente-extra.edit', $cliente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('cliente-extra.destroy', $cliente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
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
                    <p>Nenhum cliente encontrado.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
