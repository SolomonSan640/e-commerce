<?php

namespace App\Filament\Resources\MedalResource\Pages;

use App\Filament\Resources\MedalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMedal extends ViewRecord
{
    protected static string $resource = MedalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
