<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('key')
                    ->disabled(),
                TextInput::make('description')
                    ->disabled(),
                Select::make('type')
                    ->options([
                        'text' => 'Texto',
                        'textarea' => 'Area de texto',
                        'image' => 'URL de imagen',
                        'json' => 'JSON',
                        'boolean' => 'Booleano',
                    ])
                    ->disabled(),
                TextInput::make('group')
                    ->disabled(),
                
                Placeholder::make('value_label')
                    ->content('Valor:')
                    ->columnSpanFull(),
                
                TextInput::make('value')
                    ->columnSpanFull(),
                
                Textarea::make('value_textarea')
                    ->visible(fn ($get) => $get('type') === 'textarea')
                    ->columnSpanFull(),
                
                Toggle::make('bool_value')
                    ->visible(fn ($get) => $get('type') === 'boolean'),
                
                KeyValue::make('json_value')
                    ->visible(fn ($get) => $get('type') === 'json'),
            ]);
    }
}
