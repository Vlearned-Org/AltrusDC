<?php

namespace App\Filament\Resources\GovernanceDataResource\Pages;

use App\Filament\Resources\GovernanceDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGovernanceData extends ManageRecords
{
    protected static string $resource = GovernanceDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
