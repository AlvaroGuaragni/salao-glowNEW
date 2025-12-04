<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Servico;
use Illuminate\Support\Facades\DB;

class ServicosPerMesLine
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        $byMonth = Servico::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $labelsLine = array_keys($byMonth);
        $valuesLine = array_values($byMonth);

        return $this->chart->lineChart()
            ->setTitle('Serviços Criados por Mês')
            ->setSubtitle('Últimos meses')
            ->addLine('Serviços', $valuesLine)
            ->setXAxis($labelsLine);
    }
}
