<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Meu Perfil</h2>
    </x-slot>

    <div class="py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if(session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Perfil atualizado com sucesso!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Senha atualizada com sucesso!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
