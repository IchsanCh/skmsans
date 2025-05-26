<?php

namespace App\Filament\Resources\ResponseAnswerResource\Pages;

use App\Filament\Resources\ResponseAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResponseAnswer extends EditRecord
{
    protected static string $resource = ResponseAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
