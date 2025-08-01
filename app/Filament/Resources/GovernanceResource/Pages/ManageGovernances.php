<?php

namespace App\Filament\Resources\GovernanceResource\Pages;

use App\Filament\Resources\GovernanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGovernances extends ManageRecords
{
    protected static string $resource = GovernanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
