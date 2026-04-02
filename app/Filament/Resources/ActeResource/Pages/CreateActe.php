<?php

namespace App\Filament\Resources\ActeResource\Pages;

use App\Filament\Resources\ActeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateActe extends CreateRecord
{
    protected static string $resource = ActeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (auth()->user()->isHuissier()) {
            $data['huissier_id'] = auth()->user()->huissier_id;
        }
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
