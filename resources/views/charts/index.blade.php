@extends('layouts.base')

@section('title', 'Gráficos')

@section('content')
    <h1 class="mb-4">Gráficos</h1>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-body">
                    {!! $pie->container() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    {!! $line->container() !!}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    {!! $pie->script() !!}
    {!! $line->script() !!}
@endsection
