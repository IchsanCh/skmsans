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

    public function mount(): void
    {
        $currentYear = now()->year;

        $fromDate = request('from_date') ?? now()->setDate($currentYear, 1, 1)->toDateString();
        $toDate = request('to_date') ?? now()->setDate($currentYear, 12, 31)->toDateString();

        $query = SurveyResponse::query()
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
                [$min, $max] = explode('-', request('usia') . '-');
                if (is_numeric($min) && is_numeric($max)) {
                    $q->whereBetween('usia', [(int) $min, (int) $max]);
                } else {
                    $q->where('usia', 'like', '%' . request('usia') . '%');
                }
            });

        $this->data = $query->get();
        $this->units = Units::all();
        $this->services = Service::all();
    }
}
