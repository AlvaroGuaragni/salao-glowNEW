<<<<<<< HEAD
@extends('layouts.base')

@section('title', 'Meus Agendamentos')

@section('content')
    <h1 class="mb-3">Meus Agendamentos</h1>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('agendamentos.createForClient') }}" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Novo Agendamento
                </a>
            </div>

            @if($agendamentos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Serviço</th>
                                <th>Data / Hora</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agendamentos as $agendamento)
                                <tr>
                                    <td>{{ $agendamento->servico->nome ?? 'Serviço excluído' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($agendamento->data_hora)->format('d/m/Y \à\s H:i') }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($agendamento->status) }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center p-4 text-muted">
                    <p>Você ainda não possui nenhum agendamento.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
=======
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Agendamentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if(session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <a href="{{ route('agendamentos.createForClient') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Fazer Novo Agendamento
                        </a>
                    </div>


                    @if($agendamentos->count() > 0)
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
                        
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-start">Serviço</th>
                                    <th class="text-start">Data / Hora</th>
                                    <th class="text-start">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($agendamentos as $agendamento)
                                    <tr>
                                        <td>{{ $agendamento->servico->nome ?? 'Serviço excluído' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($agendamento->data_hora)->format('d/m/Y \à\s H:i') }}</td>
                                        <td>{{ ucfirst($agendamento->status) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">Você ainda não possui nenhum agendamento.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
>>>>>>> 355182ea0c0ef1c02a33d5ea304bdeeffc09c103
