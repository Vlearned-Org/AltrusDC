<?php

namespace App\Filament\Resources\SubsidiaryResource\Pages;

use App\Filament\Resources\SubsidiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSubsidiaries extends ManageRecords
{
    protected static string $resource = SubsidiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
