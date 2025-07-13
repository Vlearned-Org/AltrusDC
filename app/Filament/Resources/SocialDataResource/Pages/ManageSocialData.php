<?php

namespace App\Filament\Resources\SocialDataResource\Pages;

use App\Filament\Resources\SocialDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSocialData extends ManageRecords
{
    protected static string $resource = SocialDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
