<?php

namespace App\Filament\Resources\EconomicDataResource\Pages;

use App\Filament\Resources\EconomicDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEconomicData extends ManageRecords
{
    protected static string $resource = EconomicDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
