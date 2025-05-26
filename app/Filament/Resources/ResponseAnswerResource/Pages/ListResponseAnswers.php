<?php

namespace App\Filament\Resources\ResponseAnswerResource\Pages;

use App\Filament\Resources\ResponseAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResponseAnswers extends ListRecords
{
    protected static string $resource = ResponseAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
