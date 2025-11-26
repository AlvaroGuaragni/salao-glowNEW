@extends('layouts.base')

@section('title', $cliente->exists ? 'Editar Cliente' : 'Novo Cliente')

@section('content')
    <h1 class="mb-3">{{ $cliente->exists ? 'Editar Cliente' : 'Novo Cliente' }}</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ $cliente->exists ? route('cliente-extra.update', $cliente->id) : route('cliente-extra.store') }}" method="POST">
                @csrf
                @if($cliente->exists)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="nome" class="form-label">Nome *</label>
                    <input type="text" id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $cliente->nome ?? '') }}" required>
                    @error('nome')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $cliente->email ?? '') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" id="telefone" name="telefone" class="form-control @error('telefone') is-invalid @enderror" value="{{ old('telefone', $cliente->telefone ?? '') }}">
                            @error('telefone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" id="cep" name="cep" class="form-control @error('cep') is-invalid @enderror" value="{{ old('cep', $cliente->cep ?? '') }}">
                            @error('cep')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="endereco" class="form-label">Endereço</label>
                    <input type="text" id="endereco" name="endereco" class="form-control @error('endereco') is-invalid @enderror" value="{{ old('endereco', $cliente->endereco ?? '') }}">
                    @error('endereco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" id="cidade" name="cidade" class="form-control @error('cidade') is-invalid @enderror" value="{{ old('cidade', $cliente->cidade ?? '') }}">
                            @error('cidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" id="estado" name="estado" class="form-control @error('estado') is-invalid @enderror" maxlength="2" value="{{ old('estado', $cliente->estado ?? '') }}">
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="observacoes" class="form-label">Observações</label>
                    <textarea id="observacoes" name="observacoes" class="form-control @error('observacoes') is-invalid @enderror" rows="3">{{ old('observacoes', $cliente->observacoes ?? '') }}</textarea>
                    @error('observacoes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">{{ $cliente->exists ? 'Atualizar' : 'Cadastrar' }}</button>
                    <a href="{{ route('cliente-extra.index') }}" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
