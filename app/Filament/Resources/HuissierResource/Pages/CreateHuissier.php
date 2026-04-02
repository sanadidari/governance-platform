<?php

namespace App\Filament\Resources\HuissierResource\Pages;

use App\Filament\Resources\HuissierResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHuissier extends CreateRecord
{
    protected static string $resource = HuissierResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $password = $data['password'] ?? null;
        unset($data['password']);

        $record = new ($this->getModel())($data);
        $record->plain_password = $password; // Pass to Observer
        $record->save();

        return $record;
    }
}
