<section>
    <h5 class="mb-3">Informações do Perfil</h5>
    <p class="text-muted small mb-4">Atualize as informações da sua conta e endereço de e-mail.</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
            />
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                value="{{ old('email', $user->email) }}" 
                required 
            />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <div class="alert alert-warning" role="alert">
                        <strong>Seu endereço de e-mail não foi verificado.</strong>
                        <button form="send-verification" class="btn btn-link p-0 ms-2 text-decoration-underline">
                            Clique aqui para reenviar o e-mail de verificação.
                        </button>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success mt-2">
                            Um novo link de verificação foi enviado para o seu endereço de e-mail.
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">Salvar</button>
            @if (session('status') === 'profile-updated')
                <span class="text-success small">Salvo!</span>
            @endif
        </div>
    </form>
</section>
