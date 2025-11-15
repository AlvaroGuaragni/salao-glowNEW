<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

<<<<<<< HEAD
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="min-vh-100">
=======
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
>>>>>>> 355182ea0c0ef1c02a33d5ea304bdeeffc09c103
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
<<<<<<< HEAD
                <header class="bg-white shadow-sm mb-4">
                    <div class="container py-3">
=======
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
>>>>>>> 355182ea0c0ef1c02a33d5ea304bdeeffc09c103
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
<<<<<<< HEAD
            <main class="container">
                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
=======
            <main>
                {{ $slot }}
            </main>
        </div>
>>>>>>> 355182ea0c0ef1c02a33d5ea304bdeeffc09c103
    </body>
</html>
