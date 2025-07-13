<?php

namespace App\Filament\Resources\EnvironmentDataResource\Pages;

use App\Filament\Resources\EnvironmentDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEnvironmentData extends ManageRecords
{
    protected static string $resource = EnvironmentDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
