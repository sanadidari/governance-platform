<?php

namespace App\Filament\Resources\ActeResource\Pages;

use App\Filament\Resources\ActeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActe extends EditRecord
{
    protected static string $resource = ActeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
