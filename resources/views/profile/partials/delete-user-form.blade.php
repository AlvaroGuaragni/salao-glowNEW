<section>
    <h5 class="mb-3 text-danger">Excluir Conta</h5>
    <p class="text-muted small mb-4">
        Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente excluídos. Antes de excluir sua conta, faça o download de quaisquer dados ou informações que você deseja manter.
    </p>

    <button 
        type="button" 
        class="btn btn-danger" 
        data-bs-toggle="modal" 
        data-bs-target="#confirmUserDeletionModal"
    >
        Excluir Conta
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p class="mb-3">
                            <strong>Tem certeza de que deseja excluir sua conta?</strong>
                        </p>
                        <p class="text-muted small mb-3">
                            Uma vez que sua conta for excluída, todos os seus recursos e dados serão permanentemente excluídos. Por favor, digite sua senha para confirmar.
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif"
                                required
                            />
                            @if($errors->userDeletion->has('password'))
                                <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir Conta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
