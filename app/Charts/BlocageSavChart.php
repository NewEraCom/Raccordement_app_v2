<?php

namespace App\Charts;

use App\Models\feedback;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class BlocageSavChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $results = feedback::select('type_blockage', DB::raw('count(*) as count'))
            ->groupBy('type_blockage')
            ->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)
            ->get();


        foreach ($results as $value) {
            $causes[] = $value->type_blockage;
            $data[] = $value->count;
        }

        return $this->chart->donutChart()
            ->addData($data ?? [])
            ->setLabels($causes ?? [])
            ->setColors(['#FF7900', '#6A4C28', '#9028F1', '#4B25BE', '#0EBE75', '#F8C5A0', '#E84E58', '#FECA39', '#8DD9D4']);
    }
}
