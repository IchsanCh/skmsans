<?php

namespace App\Filament\Resources\SurveyResponseResource\Pages;

use App\Models\Units;
use App\Models\Service;
use App\Models\SurveyResponse;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\SurveyResponseResource;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

class SurveyReport extends Page
{
    protected static string $resource = SurveyResponseResource::class;

    protected static string $view = 'filament.resources.survey-response-resource.pages.survey-report';

    public $data;
    public $units;
    public $services;
    public $totalRecords;
    public $currentPage;
    public $perPage = 50; // Jumlah data per halaman

    public function mount(): void
    {
        set_time_limit(300); // 5 menit (300 detik)
        ini_set('memory_limit', '1g');

        $this->units = Units::all();
        $this->services = Service::all();
        $this->currentPage = request('page', 1);

        $this->loadData();
    }

    private function loadData()
    {
        $fromDate = request('from_date') ?? now()->startOfMonth()->toDateString();
        $toDate = request('to_date') ?? now()->endOfMonth()->toDateString();

        $query = $this->buildBaseQuery($fromDate, $toDate);

        // Hitung total records
        $this->totalRecords = $query->count();

        // Load data dengan paginasi
        $this->data = $query
            ->with(['responseAnswers.questionOption'])
            ->skip(($this->currentPage - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();
    }

    private function buildBaseQuery($fromDate, $toDate)
    {
        return SurveyResponse::query()
            ->with(['unit', 'service'])
            ->when($fromDate, fn($q) =>
            $q->whereDate('created_at', '>=', $fromDate))
            ->when($toDate, fn($q) =>
            $q->whereDate('created_at', '<=', $toDate))
            ->when(request('unit_id'), fn($q) =>
            $q->where('unit_id', request('unit_id')))
            ->when(request('service_id'), fn($q) =>
            $q->where('service_id', request('service_id')))
            ->when(request('jenis_kelamin'), fn($q) =>
            $q->where('jenis_kelamin', request('jenis_kelamin')))
            ->when(request('usia'), function ($q) {
                $usia = request('usia');
                if (strpos($usia, '-') !== false) {
                    [$min, $max] = explode('-', $usia);
                    if (is_numeric($min) && is_numeric($max)) {
                        $q->whereBetween('usia', [(int) $min, (int) $max]);
                    }
                } else {
                    $q->where('usia', 'like', '%' . $usia . '%');
                }
            })
            ->orderBy('created_at', 'desc');
    }

    // Method untuk export yang mengambil semua data
    public function getAllDataForExport()
    {
        $fromDate = request('from_date') ?? now()->startOfMonth()->toDateString();
        $toDate = request('to_date') ?? now()->endOfMonth()->toDateString();

        return $this->buildBaseQuery($fromDate, $toDate)
            ->with(['responseAnswers.questionOption', 'unit', 'service'])
            ->get();
    }

    // Helper methods untuk pagination
    public function getTotalPages()
    {
        return ceil($this->totalRecords / $this->perPage);
    }

    public function hasNextPage()
    {
        return $this->currentPage < $this->getTotalPages();
    }

    public function hasPreviousPage()
    {
        return $this->currentPage > 1;
    }

    public function getNextPageUrl()
    {
        if (!$this->hasNextPage()) return null;

        $params = request()->query();
        $params['page'] = $this->currentPage + 1;
        return request()->url() . '?' . http_build_query($params);
    }

    public function getPreviousPageUrl()
    {
        if (!$this->hasPreviousPage()) return null;

        $params = request()->query();
        $params['page'] = $this->currentPage - 1;
        return request()->url() . '?' . http_build_query($params);
    }

    public function getPageUrl($page)
    {
        $params = request()->query();
        $params['page'] = $page;
        return request()->url() . '?' . http_build_query($params);
    }

    // Method untuk mendapatkan range halaman yang ditampilkan
    public function getPageRange()
    {
        $totalPages = $this->getTotalPages();
        $currentPage = $this->currentPage;

        $start = max(1, $currentPage - 2);
        $end = min($totalPages, $currentPage + 2);

        // Pastikan selalu menampilkan 5 halaman jika memungkinkan
        if ($end - $start < 4) {
            if ($start == 1) {
                $end = min($totalPages, $start + 4);
            } else {
                $start = max(1, $end - 4);
            }
        }

        return range($start, $end);
    }
}
