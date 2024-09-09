<?php

namespace App\Filament\Resources\CurrencyPointResource\Pages;

use App\Filament\Resources\CurrencyPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCurrencyPoints extends ListRecords
{
    protected static string $resource = CurrencyPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
