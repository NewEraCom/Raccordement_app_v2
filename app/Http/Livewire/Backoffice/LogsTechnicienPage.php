<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\TechnicienLog;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Soustraitant;
use Carbon\Carbon;

class LogsTechnicienPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $text, $soustraitant_id, $start_date, $end_date, $status;

    public function render()
    {
        $soustraitants = Soustraitant::get(['id', 'name']);
        $logs = TechnicienLog::with('technicien')
            ->whereHas('technicien', function ($query) {
                $query->when($this->soustraitant_id, function ($query) {
                    $query->where('soustraitant_id', $this->soustraitant_id);
                });
            })
            ->where(function ($query) {
                $query->when($this->text, function ($query) {
                    $query->whereHas('technicien.user', function ($q) {
                        $q->whereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", '%' . trim($this->text) . '%');
                    })->orWhereHas('technicien.cities', function ($query) {
                        $query->where('name', 'like', '%' . $this->text . '%');
                    });
                });
            })
            ->when($this->start_date && $this->end_date, function ($query) {
                $query->whereBetween('created_at', [
                    Carbon::parse($this->start_date)->startOfDay(),
                    Carbon::parse($this->end_date)->endOfDay()
                ]);
            })->when($this->status, function ($query) {
                $query->where('nb_affectation', '=', $this->status == 'NaN' ? 0 : $this->status);
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(25);

        return view('livewire.backoffice.logs-technicien-page', compact('logs', 'soustraitants'))->layout('layouts.app', ['title' => 'Logs']);
    }
}
