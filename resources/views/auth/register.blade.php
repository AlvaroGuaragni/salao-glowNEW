<x-guest-layout>
    <h3 class="mb-4 text-center">Registrar</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome Completo *</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cpf" class="form-label">CPF *</label>
            <input id="cpf" type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" value="{{ old('cpf') }}" required>
            @error('cpf')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="telefone" class="form-label">Telefone (com DDD)</label>
            <input id="telefone" type="tel" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone') }}">
            @error('telefone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Senha *</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Senha *</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success mb-3">
                Registrar
            </button>
        </div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="text-decoration-none">
                Já tem conta? Faça login
            </a>
        </div>
    </form>
</x-guest-layout>
