<?php

namespace App\Filament\Resources\BusinessTravelResource\Pages;

use App\Filament\Resources\BusinessTravelResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBusinessTravel extends ManageRecords
{
    protected static string $resource = BusinessTravelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
