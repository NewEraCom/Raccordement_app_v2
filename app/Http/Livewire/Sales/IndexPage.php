<?php

namespace App\Http\Livewire\Sales;

use App\Exports\ClientsExport;
use App\Exports\SalesExport;
use App\Models\Client;
use App\Models\Soustraitant;
use App\Models\Technicien;
use App\Services\web\ClientsService;
use Livewire\Component;
use Livewire\WithPagination;

class IndexPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $client_name = '', $client_sip = '', $client_status = '', $technicien = '', $start_date = '', $end_date = '';

    public function export()
    {
        $this->emit('success');
        return (new SalesExport($this->start_date, $this->end_date))->download('clients_' . now()->format('d_m_Y_H_i_s') . '.xlsx');
    }

    public function render()
    {
        $soustraitant = Soustraitant::get();
        $techniciens = Technicien::get();
        $clients = ClientsService::getClients($this->client_name, $this->client_sip, $this->client_status, $this->technicien, $this->start_date, $this->end_date)->paginate(15);

        return view('livewire.sales.index-page',compact('clients','soustraitant','techniciens'))->layout('layouts.app',[ 'title' => 'Commercial']);
    }
}
