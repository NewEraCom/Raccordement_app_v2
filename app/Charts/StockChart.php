<?php

namespace App\Charts;

use App\Services\web\StockService;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class StockChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {

        $stock = StockService::getDetailsStock();

        return $this->chart->pieChart()
            ->addData([$stock['splitter'],$stock['splitter']]);
    }
}
