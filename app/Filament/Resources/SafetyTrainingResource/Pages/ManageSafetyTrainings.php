<?php

namespace App\Filament\Resources\SafetyTrainingResource\Pages;

use App\Filament\Resources\SafetyTrainingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSafetyTrainings extends ManageRecords
{
    protected static string $resource = SafetyTrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
