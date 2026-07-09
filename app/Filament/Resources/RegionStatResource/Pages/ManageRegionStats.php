<?php

namespace App\Filament\Resources\RegionStatResource\Pages;

use App\Filament\Resources\RegionStatResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageRegionStats extends ManageRecords
{
    protected static string $resource = RegionStatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
