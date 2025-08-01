<?php

namespace App\Filament\Resources\EmployeeCommutingResource\Pages;

use App\Filament\Resources\EmployeeCommutingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmployeeCommutings extends ManageRecords
{
    protected static string $resource = EmployeeCommutingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
