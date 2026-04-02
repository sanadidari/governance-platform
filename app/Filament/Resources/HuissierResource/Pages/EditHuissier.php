<?php

namespace App\Filament\Resources\HuissierResource\Pages;

use App\Filament\Resources\HuissierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHuissier extends EditRecord
{
    protected static string $resource = HuissierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
