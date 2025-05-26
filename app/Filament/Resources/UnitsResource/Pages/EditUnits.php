<?php

namespace App\Filament\Resources\UnitsResource\Pages;

use App\Filament\Resources\UnitsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnits extends EditRecord
{
    protected static string $resource = UnitsResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Departement Edited';
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
