<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Servico;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(LarapexChart $chart)
    {
        // Dados para gráfico pizza: contagem por faixa de preço (a tabela não tem coluna 'categoria')
        $ranges = [
            'Até 50' => [0, 50],
            '51 - 100' => [51, 100],
            '101 - 200' => [101, 200],
            '201+' => [201, 1000000],
        ];

        $labelsPie = [];
        $valuesPie = [];

        foreach ($ranges as $label => [$min, $max]) {
            $count = Servico::where('preco', '>=', $min)
                ->where('preco', '<=', $max)
                ->count();
            $labelsPie[] = $label;
            $valuesPie[] = $count;
        }

        $pie = $chart->pieChart()
            ->setTitle('Serviços por Faixa de Preço')
            ->setSubtitle('Distribuição de serviços por preço')
            ->setLabels($labelsPie)
            ->addPieces($valuesPie);

        // Dados para gráfico de linha: serviços criados por mês
        $byMonth = Servico::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $labelsLine = array_keys($byMonth);
        $valuesLine = array_values($byMonth);

        $line = $chart->lineChart()
            ->setTitle('Serviços Criados por Mês')
            ->setSubtitle('Últimos meses')
            ->addLine('Serviços', $valuesLine)
            ->setXAxis($labelsLine);

        return view('charts.index', compact('pie', 'line'));
    }
}
