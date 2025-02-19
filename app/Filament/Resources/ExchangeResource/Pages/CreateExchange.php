<?php

namespace App\Filament\Resources\ExchangeResource\Pages;

use App\Filament\Resources\ExchangeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExchange extends CreateRecord
{
    protected static string $resource = ExchangeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
