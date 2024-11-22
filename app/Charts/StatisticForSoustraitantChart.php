<?php

namespace App\Charts;

use App\Models\Soustraitant;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Database\Eloquent\Builder;

class StatisticForSoustraitantChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {

        $soustraitant = Soustraitant::withCount(['affectations','declarations','blocages','planifications'])->where('name','!=','TEST_NEWERACOM')->get();

        foreach ($soustraitant as $soustraitant) {
            $soustraitants[] = $soustraitant->name;
            $affectations[] = $soustraitant->affectations_count;
            $declarations[] = $soustraitant->declarations_count;
            $planifications[] = $soustraitant->planifications_count;
            $blocages[] = $soustraitant->blocages_count ?? 0;
        }

        return $this->chart->barChart()
            ->addData('Affectations', $affectations ?? [])
            ->addData('Declarations', $declarations ?? [])
            ->addData('Blocages', $blocages ?? [])
            ->addData('Planifications', $planifications ?? [])
            ->setXAxis($soustraitants ?? [])
            ->setColors(['#0ACF97', '#727CF5', '#F36E89','#FFBA58']);
    }
}
