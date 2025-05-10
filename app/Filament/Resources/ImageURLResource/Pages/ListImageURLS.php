<?php

namespace App\Filament\Resources\ImageURLResource\Pages;

use App\Filament\Resources\ImageURLResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImageURLS extends ListRecords
{
    protected static string $resource = ImageURLResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
