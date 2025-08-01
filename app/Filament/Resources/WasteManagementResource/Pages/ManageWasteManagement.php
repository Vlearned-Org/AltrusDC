<?php

namespace App\Filament\Resources\WasteManagementResource\Pages;

use App\Filament\Resources\WasteManagementResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageWasteManagement extends ManageRecords
{
    protected static string $resource = WasteManagementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
