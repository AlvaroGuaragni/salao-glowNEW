<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Salão Glow')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body class="bg-light-subtle">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #5f5a5eff;">
            <div class="container">
                <a class="navbar-brand" href="/">Salão Glow</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @auth
                            @if(auth()->user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('clientes.index') }}">Clientes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('servicos.index') }}">Serviços</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('agendamentos.index') }}">Agendamentos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('pagamentos.index') }}">Pagamentos</a>
                                </li>
                            @endif

                            @if(auth()->user()->role == 'cliente')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboard') }}">Meus Agendamentos</a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile.edit') }}">
                                    {{ auth()->user()->name }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="nav-link" href="{{ route('logout') }}"onclick="event.preventDefault(); this.closest('form').submit();">
                                        Sair
                                    </a>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registrar</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>