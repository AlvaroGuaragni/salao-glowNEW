@extends('layouts.base')

@section('title', $produto->exists ? 'Editar Produto' : 'Novo Produto')

@section('content')
    <h1 class="mb-3">{{ $produto->exists ? 'Editar Produto' : 'Novo Produto' }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ $produto->exists ? route('produtos.update', $produto->id) : route('produtos.store') }}" method="POST">
                @csrf
                @if($produto->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome *</label>
                    <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $produto->nome ?? '') }}" required>
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control @error('descricao') is-invalid @enderror" rows="3">{{ old('descricao', $produto->descricao ?? '') }}</textarea>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="marca" class="form-label">Marca</label>
                            <input type="text" id="marca" name="marca" class="form-control @error('marca') is-invalid @enderror" value="{{ old('marca', $produto->marca ?? '') }}">
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="preco" class="form-label">Preço (R$) *</label>
                            <input type="number" id="preco" name="preco" class="form-control @error('preco') is-invalid @enderror" step="0.01" min="0" value="{{ old('preco', $produto->preco ?? '') }}" required>
                            @error('preco')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="estoque" class="form-label">Estoque (unidades) *</label>
                            <input type="number" id="estoque" name="estoque" class="form-control @error('estoque') is-invalid @enderror" min="0" value="{{ old('estoque', $produto->estoque ?? '') }}" required>
                            @error('estoque')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">{{ $produto->exists ? 'Atualizar' : 'Cadastrar' }}</button>
                    <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
