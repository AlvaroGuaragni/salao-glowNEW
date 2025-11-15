<section>
    <h5 class="mb-3">Atualizar Senha</h5>
    <p class="text-muted small mb-4">Certifique-se de que sua conta está usando uma senha longa e aleatória para manter a segurança.</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Senha Atual</label>
            <input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif" 
            />
            @if($errors->updatePassword->has('current_password'))
                <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">Nova Senha</label>
            <input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif" 
            />
            @if($errors->updatePassword->has('password'))
                <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Confirmar Nova Senha</label>
            <input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="form-control" 
            />
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">Salvar</button>
            @if (session('status') === 'password-updated')
                <span class="text-success small">Salvo!</span>
            @endif
        </div>
    </form>
</section>
