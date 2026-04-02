<?php

namespace App\Filament\Resources\RegionalAdminResource\Pages;

use App\Filament\Resources\RegionalAdminResource;
use Filament\Resources\Pages\ListRecords;

class ListRegionalAdmins extends ListRecords
{
    protected static string $resource = RegionalAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
