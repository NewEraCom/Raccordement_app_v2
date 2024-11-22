<?php

namespace App\Http\Livewire\Soustraitant;

use App\Services\web\TechniciensService;
use Livewire\Component;
use Livewire\WithPagination;

class SoustraitantTechnicienPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $filtrage_name = '', $start_date = '', $end_date = '', $status = '', $soustraitant_selected = '';

    public function render()
    {
        $techniciens = TechniciensService::returnTechniciens($this->filtrage_name, $this->soustraitant_selected, $this->status, $this->start_date, $this->end_date)->paginate(15);
        return view('livewire.soustraitant.soustraitant-technicien-page', compact(['techniciens']))->layout('layouts.app', ['title' => 'Techniciens']);
    }
}
