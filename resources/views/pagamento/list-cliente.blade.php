<<<<<<< HEAD
@extends('layouts.base')

@section('title', 'Meus Pagamentos')

@section('content')
    <h1 class="mb-3">Meus Pagamentos</h1>

    <div class="card">
        <div class="card-body">
            @if($pagamentos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Agendamento</th>
                                <th>Serviço</th>
                                <th>Valor</th>
                                <th>Método</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagamentos as $pagamento)
                                <tr>
                                    <td>#{{ $pagamento->agendamento_id }}</td>
                                    <td>{{ $pagamento->agendamento->servico->nome ?? '-' }}</td>
                                    <td>R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                                    <td>{{ ucfirst($pagamento->metodo) }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($pagamento->status) }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pagamentos->links() }}
                </div>
            @else
                <div class="text-center p-4 text-muted">
                    <p>Você ainda não possui nenhum pagamento registrado.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
=======
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Pagamentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

                    @if($pagamentos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="text-start">Agendamento</th>
                                        <th class="text-start">Serviço</th>
                                        <th class="text-start">Valor</th>
                                        <th class="text-start">Método</th>
                                        <th class="text-start">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pagamentos as $pagamento)
                                        <tr>
                                            <td>#{{ $pagamento->agendamento_id }}</td>
                                            <td>{{ $pagamento->agendamento->servico->nome ?? '-' }}</td>
                                            <td>R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                                            <td>{{ ucfirst($pagamento->metodo) }}</td>
                                            <td>{{ ucfirst($pagamento->status) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $pagamentos->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">Você ainda não possui nenhum pagamento registrado.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
>>>>>>> 355182ea0c0ef1c02a33d5ea304bdeeffc09c103
