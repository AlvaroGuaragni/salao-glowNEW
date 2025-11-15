@extends('layouts.base')
@section('title', 'Página Inicial - Salão Glow')

@section('content')
    <div class="card shadow-sm border-0" style="background-color: #f084daff; padding: 25px;">
        <div class="card-body">
            <h1 class="card-title mb-3">Bem-vindo ao nosso site do Salão Glow!</h1>
            <p class="card-text text-muted">
                Selecione uma das opções abaixo para continuar.
            </p>
        </div>
    </div>

    <div class="row mt-4 g-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0" style="background-color: #f084daff;">
                <div class="card-body text-center p-4 text-black" >
                    <i class="bi bi-shield-lock-fill fs-1 text-black mb-3"></i>
                    <h5 class="card-title">Acesso do Administrador</h5>
                    <p class="card-text text-muted text-black">
                        Gerenciamento dos clientes, serviços, agendamentos e pagamentos.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-lg">
                        Entrar na Gestão
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-0" style="background-color: #f084daff;">
                <div class="card-body text-center text-black p-4">
                    <i class="bi bi-person-fill fs-1 text-success text-black mb-3"></i>
                    <h5 class="card-title">Portal do Cliente</h5>
                    <p class="card-text text-muted">
                        Faça login ou registre-se para ver seus agendamentos.
                    </p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('login') }}" class="btn btn-secondary btn-lg px-4 gap-3">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-secondary btn-lg px-4">
                            Registrar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
