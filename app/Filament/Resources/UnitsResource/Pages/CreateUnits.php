<?php

namespace App\Filament\Resources\UnitsResource\Pages;

use App\Filament\Resources\UnitsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUnits extends CreateRecord
{
    protected static string $resource = UnitsResource::class;
    protected static ?string $title = 'Tambah Unit Departemen';
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Departement Created';
    }
}
