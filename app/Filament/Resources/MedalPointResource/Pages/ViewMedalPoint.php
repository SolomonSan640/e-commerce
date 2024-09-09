<?php

namespace App\Filament\Resources\MedalPointResource\Pages;

use App\Filament\Resources\MedalPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMedalPoint extends ViewRecord
{
    protected static string $resource = MedalPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
