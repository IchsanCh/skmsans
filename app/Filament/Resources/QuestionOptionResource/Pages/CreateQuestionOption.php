<?php

namespace App\Filament\Resources\QuestionOptionResource\Pages;

use App\Filament\Resources\QuestionOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateQuestionOption extends CreateRecord
{
    protected static string $resource = QuestionOptionResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Options Created';
    }
}
