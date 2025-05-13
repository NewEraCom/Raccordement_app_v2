<?php

namespace App\Http\Livewire\Backoffice;

use App\Models\Blocage;
use App\Models\Declaration;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use ZipArchive;
use PDF;
use Illuminate\Support\Facades\Storage;

class ReportsPageView extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search_term, $end_date_dec, $start_date_dec, $end_date, $start_date;
    public $search_term_dec;
    public $selectedItems = [];
    public $selectedItems_dec = [];
    public $imageOrder = [
        'Photo façade',
        'PBI (Fermé)',
        'PBI (Ouvert)',
        'Splitter 1',
        'Splitter 2',
        'PBO (Fermé)',
        'PBO (Ouvert)',
        'Splitter 3',
        'Splitter 4',
        'Chambre (Fermé)',
        'Chambre (Ouvert)',
    ];



    public function downloadSelectedReports()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Veuillez sélectionner au moins un rapport');
            return;
        }

        $zipFileName = 'rapports_blocages_' . now()->format('Y-m-d_H-i-s') . '.zip';
        $zip = new ZipArchive();
        $zipPath = storage_path('app/public/temp/' . $zipFileName);

        if (!Storage::exists('public/temp')) {
            Storage::makeDirectory('public/temp');
        }

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($this->selectedItems as $blocageId) {
                $blocage = Blocage::with(['affectation.client'])->find($blocageId);

                if ($blocage) {
                    $pdf = PDF::loadView('blocage-report', ['blocage' => $blocage, 'imageOrder' => $this->imageOrder]);
                    $pdfFileName = 'RAPPORT_BLOCAGE_' . $blocage->affectation->client->name . '_' .
                        $blocage->affectation->client->sip . '.pdf';

                    $tempPdfPath = storage_path('app/public/temp/' . $pdfFileName);
                    $pdf->save($tempPdfPath);

                    $zip->addFile($tempPdfPath, $pdfFileName);
                }
            }

            $zip->close();

            // Clean up temporary PDF files
            foreach ($this->selectedItems as $blocageId) {
                $blocage = Blocage::with(['affectation.client'])->find($blocageId);
                if ($blocage) {
                    $pdfFileName = 'RAPPORT_BLOCAGE_' . $blocage->affectation->client->name . '_' .
                        $blocage->affectation->client->sip . '.pdf';
                    $tempPdfPath = storage_path('app/public/temp/' . $pdfFileName);
                    if (file_exists($tempPdfPath)) {
                        unlink($tempPdfPath);
                    }
                }
            }

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        session()->flash('error', 'Une erreur est survenue lors de la création du fichier ZIP');
    }

    public function downloadSelectedReportsDec()
    {
        if (empty($this->selectedItems_dec)) {
            session()->flash('error', 'Veuillez sélectionner au moins un rapport');
            return;
        }

        $zipFileName = 'rapports_declarations_' . now()->format('Y-m-d_H-i-s') . '.zip';
        $zip = new ZipArchive();
        $zipPath = storage_path('app/public/temp/' . $zipFileName);

        if (!Storage::exists('public/temp')) {
            Storage::makeDirectory('public/temp');
        }

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($this->selectedItems_dec as $declarationId) {
                $declaration = Declaration::with(['affectation.client'])->find($declarationId);

                if ($declaration) {
                    $pdf = PDF::loadView('pdf-rapport', ['client' => $declaration->affectation->client]);
                    $pdfFileName = 'RAPPORT_DECLARATION_' . $declaration->affectation->client->name . '_' .
                        $declaration->affectation->client->sip . '.pdf';

                    $tempPdfPath = storage_path('app/public/temp/' . $pdfFileName);
                    $pdf->save($tempPdfPath);

                    $zip->addFile($tempPdfPath, $pdfFileName);
                }
            }

            $zip->close();

            // Clean up temporary PDF files
            foreach ($this->selectedItems_dec as $declarationId) {
                $declaration = Declaration::with(['affectation.client'])->find($declarationId);
                if ($declaration) {
                    $pdfFileName = 'RAPPORT_DECLARATION_' . $declaration->affectation->client->name . '_' .
                        $declaration->affectation->client->sip . '.pdf';
                    $tempPdfPath = storage_path('app/public/temp/' . $pdfFileName);
                    if (file_exists($tempPdfPath)) {
                        unlink($tempPdfPath);
                    }
                }
            }

            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        session()->flash('error', 'Une erreur est survenue lors de la création du fichier ZIP');
    }

    public function render()
    {
        $data = Blocage::query()
            ->when($this->search_term, function ($query) {
                $search_term = $this->search_term;
                return $query->whereHas('affectation.client', function ($q) use ($search_term) {
                    $q->where('name', 'like', '%' . $search_term . '%');
                })
                    ->orWhere('cause', 'like', '%' . $search_term . '%');
            })
            ->when($this->start_date, function ($query) {
                return $query->whereDate('created_at', '>=', $this->start_date);
            })
            ->when($this->end_date, function ($query) {
                return $query->whereDate('created_at', '<=', $this->end_date);
            })
            ->orderBy('created_at', 'DESC')
            ->with('affectation.client', 'affectation.technicien.user')
            ->paginate(5);

        $declarations = Declaration::query()
            ->when($this->search_term_dec, function ($query) {
                $search_term_dec = $this->search_term_dec;
                return $query->whereHas('affectation.client', function ($q) use ($search_term_dec) {
                    $q->where('name', 'like', '%' . $search_term_dec . '%');
                });
            })
            ->when($this->search_term_dec, function ($query) {
                $search_term_dec = $this->search_term_dec;
                return $query->whereHas('routeur', function ($q) use ($search_term_dec) {
                    $q->where('sn_gpon', 'like', '%' . $search_term_dec . '%');
                    $q->where('sn_mac', 'like', '%' . $search_term_dec . '%');
                });
            })
            ->when($this->start_date_dec, function ($query) {
                return $query->whereDate('created_at', '>=', $this->start_date_dec);
            })
            ->when($this->end_date_dec, function ($query) {
                return $query->whereDate('created_at', '<=', $this->end_date_dec);
            })
            ->orderBy('created_at', 'DESC')
            ->with('affectation.client.validations', 'routeur')
            ->paginate(5);

        return view('livewire.backoffice.reports-page', compact('data', 'declarations'))->layout('layouts.app', [
            'title' => 'Rapports',
        ]);
    }
}
