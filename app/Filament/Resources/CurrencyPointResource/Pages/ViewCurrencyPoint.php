<?php

namespace App\Filament\Resources\CurrencyPointResource\Pages;

use App\Filament\Resources\CurrencyPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCurrencyPoint extends ViewRecord
{
    protected static string $resource = CurrencyPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
