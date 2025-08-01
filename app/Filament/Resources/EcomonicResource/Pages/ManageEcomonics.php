<?php

namespace App\Filament\Resources\EcomonicResource\Pages;

use App\Filament\Resources\EcomonicResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEcomonics extends ManageRecords
{
    protected static string $resource = EcomonicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
