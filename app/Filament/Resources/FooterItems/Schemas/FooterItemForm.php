<?php

namespace App\Filament\Resources\FooterItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FooterItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('section')
                    ->options([
                        'categories' => 'Categorias',
                        'legal' => 'Legal',
                        'info' => 'Informacion',
                        'social' => 'Redes Sociales',
                    ])
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('link_url')
                    ->url(),
                Textarea::make('content')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->default(true),
                TextInput::make('order')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
