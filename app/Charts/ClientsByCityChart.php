<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class ClientsByCityChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $clients = DB::table('clients')->groupBy('city_id')->join('cities','clients.city_id','=','cities.id')->selectRaw('count(*) as total, cities.name as city')->where('clients.deleted_at',null)->get();
        foreach ($clients as $client) {
           $cities [] = $client->city;
           $data [] = $client->total;
        }
        return $this->chart->pieChart()
            ->addData($data ?? [])
            ->setLabels($cities ?? [])->setColors(['#FF7900','#6A4C28','#9028F1','#4B25BE','#0EBE75','#F8C5A0','#E84E58','#FECA39','#8DD9D4']);
    }
}
