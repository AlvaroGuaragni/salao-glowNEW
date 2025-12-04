<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Charts\ServicosPorFaixaPrecoPie;
use App\Charts\ServicosPerMesLine;

class ChartController extends Controller
{
    public function index(LarapexChart $chart)
    {
        $pie = (new ServicosPorFaixaPrecoPie($chart))->build();
        $line = (new ServicosPerMesLine($chart))->build();

        return view('charts.index', compact('pie', 'line'));
    }
}
