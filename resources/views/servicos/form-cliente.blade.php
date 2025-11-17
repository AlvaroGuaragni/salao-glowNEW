@extends('layouts.base')

@section('title', $servico->exists ? 'Editar Serviço' : 'Novo Serviço')

@section('content')
    <h1 class="mb-3">{{ $servico->exists ? 'Editar Serviço' : 'Novo Serviço' }}</h1>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ $servico->exists ? route('servicos.updateForClient', $servico->id) : route('servicos.storeForClient') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($servico->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome *</label>
                    <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $servico->nome ?? '') }}" required>
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control @error('descricao') is-invalid @enderror" rows="3">{{ old('descricao', $servico->descricao ?? '') }}</textarea>
                    @error('descricao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="preco" class="form-label">Preço (R$) *</label>
                    <input type="number" id="preco" name="preco" class="form-control @error('preco') is-invalid @enderror" step="0.01" min="0" value="{{ old('preco', $servico->preco ?? '') }}" required>
                    @error('preco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="duracao" class="form-label">Duração (minutos) *</label>
                    <input type="number" id="duracao" name="duracao" class="form-control @error('duracao') is-invalid @enderror" min="1" value="{{ old('duracao', $servico->duracao ?? '') }}" required>
                    @error('duracao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="imagem" class="form-label">Imagem do Serviço</label>
                    <input type="file" id="imagem" name="imagem" class="form-control @error('imagem') is-invalid @enderror" accept="image/*">
                    @error('imagem')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($servico->imagem_path)
                        <div class="mt-2">
                            <p class="text-muted mb-1">Prévia:</p>
                            <img src="{{ Storage::url($servico->imagem_path) }}" alt="Imagem do serviço" class="rounded shadow-sm" style="max-width: 220px; height: auto;">
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">{{ $servico->exists ? 'Atualizar' : 'Cadastrar' }}</button>
                    <a href="{{ route('servicos.listForClient') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
@endsection

