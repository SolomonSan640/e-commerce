<?php

namespace App\Filament\Resources\CurrencyPointResource\Pages;

use App\Filament\Resources\CurrencyPointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurrencyPoint extends EditRecord
{
    protected static string $resource = CurrencyPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
