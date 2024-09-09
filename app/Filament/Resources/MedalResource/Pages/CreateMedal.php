<?php

namespace App\Filament\Resources\MedalResource\Pages;

use App\Filament\Resources\MedalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMedal extends CreateRecord
{
    protected static string $resource = MedalResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
