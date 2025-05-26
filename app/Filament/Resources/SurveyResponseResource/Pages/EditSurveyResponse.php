<?php

namespace App\Filament\Resources\SurveyResponseResource\Pages;

use App\Filament\Resources\SurveyResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurveyResponse extends EditRecord
{
    protected static string $resource = SurveyResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
