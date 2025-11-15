<x-guest-layout>
    @if(session('status'))
        <div class="alert alert-info alert-dismissible fade show mb-3" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <h3 class="mb-4 text-center">Entrar</h3>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">
                Lembrar-me
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-decoration-none">
                    Esqueceu sua senha?
                </a>
            @endif
            <button type="submit" class="btn btn-primary">
                Entrar
            </button>
        </div>

        <div class="mt-3 text-center">
            <a href="{{ route('register') }}" class="text-decoration-none">
                Não tem conta? Registre-se
            </a>
        </div>
    </form>
</x-guest-layout>
