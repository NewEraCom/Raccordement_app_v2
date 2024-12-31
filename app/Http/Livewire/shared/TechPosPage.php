<?php

namespace App\Http\Livewire\shared;

use App\Models\TechnicienLog;
use Livewire\Component;
use Livewire\WithPagination;

class TechPosPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '';

    public function render()
    {
        $techniciens = TechnicienLog::with('technicien.user')
            ->whereHas('technicien.user', function($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        $technicien_count = TechnicienLog::count();

        return view('livewire.shared.tech-pos-page',compact('technicien_count') ,['techniciens' => $techniciens])->layout('layouts.app', [
            'title' => 'Technicien Position Analysis',
        ]);
    }
}