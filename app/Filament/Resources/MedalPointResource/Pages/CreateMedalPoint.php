<?php

namespace App\Filament\Resources\MedalPointResource\Pages;

use App\Filament\Resources\MedalPointResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMedalPoint extends CreateRecord
{
    protected static string $resource = MedalPointResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
