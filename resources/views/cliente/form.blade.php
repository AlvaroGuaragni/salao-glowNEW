@extends('layouts.base') {{-- Corrigido de 'base' para 'layouts.base' --}}

@section('title', isset($cliente->id) ? 'Editar Cliente' : 'Novo Cliente')

@section('content')
    <h1 class="mb-3">{{ isset($cliente->id) ? 'Editar Cliente' : 'Novo Cliente' }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($cliente->id) ? route('clientes.update', $cliente->id) : route('clientes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($cliente->id))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome *</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $cliente->nome) }}" required>
                </div>

                <div class="mb-3">
                    <label for="cpf" class="form-label">CPF *</label>
                    <input type="text" id="cpf" name="cpf" class="form-control" value="{{ old('cpf', $cliente->cpf) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $cliente->email) }}">
                </div>

                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" class="form-control" value="{{ old('telefone', $cliente->telefone) }}">
                </div>

                <div class="mb-3">
                    <label for="foto" class="form-label">Foto do Cliente</label>
                    <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($cliente->foto_path)
                        <div class="mt-2">
                            <p class="text-muted mb-1">Prévia:</p>
                            <img src="{{ Storage::url($cliente->foto_path) }}" alt="Foto do cliente" class="rounded shadow-sm" style="max-width: 180px; height: auto;">
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">{{ isset($cliente->id) ? 'Atualizar' : 'Cadastrar' }}</button>
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
@endsection