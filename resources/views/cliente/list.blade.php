@extends('layouts.base') {{-- Corrigido de 'base' para 'layouts.base' --}}

@section('title', 'Lista de Clientes')

@section('content')
    <h1 class="mb-3">Lista de Clientes</h1>

    <div class="card">
        <div class="card-body">
            <form method="GET" action="{{ route('clientes.index') }}" class="d-flex gap-2 mb-3">
                <input type="text" name="busca" class="form-control" value="{{ request('busca') }}" placeholder="Buscar por nome, CPF ou email...">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-warning">Limpar</a>
            </form>

            <div class="mb-3">
                <a href="{{ route('clientes.create') }}" class="btn btn-success">
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
                                <th>CPF</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente)
                                <tr>
                                    <td>{{ $cliente->id }}</td>
                                    <td>{{ $cliente->nome }}</td>
                                    <td>{{ $cliente->cpf }}</td>
                                    <td>{{ $cliente->email ?? '-' }}</td>
                                    <td>{{ $cliente->telefone ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
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