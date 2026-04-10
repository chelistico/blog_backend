<?php

namespace App\Filament\Resources\FooterItems\Pages;

use App\Filament\Resources\FooterItems\FooterItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFooterItem extends EditRecord
{
    protected static string $resource = FooterItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
