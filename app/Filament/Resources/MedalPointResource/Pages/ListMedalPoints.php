<?php

namespace App\Filament\Resources\MedalPointResource\Pages;

use App\Filament\Resources\MedalPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMedalPoints extends ListRecords
{
    protected static string $resource = MedalPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
