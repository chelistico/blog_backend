<?php

namespace App\Filament\Resources\FooterItems\Pages;

use App\Filament\Resources\FooterItems\FooterItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFooterItems extends ListRecords
{
    protected static string $resource = FooterItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
