<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Servico;

class ServicosPorFaixaPrecoPie
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
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

        return $this->chart->pieChart()
            ->setTitle('Serviços por Faixa de Preço')
            ->setSubtitle('Distribuição de serviços por preço')
            ->setLabels($labelsPie)
            ->addPieces($valuesPie);
    }
}
