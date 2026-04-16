<?php

namespace App\Filament\Resources\Advertisements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AdvertisementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('position')
                    ->options([
                        'top' => 'Top (728x90)',
                        'sidebar' => 'Sidebar (300x250)',
                        'inline' => 'Inline (728x90)',
                        'bottom' => 'Bottom (728x90)',
                        'mobile' => 'Mobile (320x100)',
                    ])
                    ->required(),
                TextInput::make('dimensions')
                    ->placeholder('ej: 728x90'),
                
                Section::make('Tipo de Anuncio')
                    ->schema([
                        Radio::make('ad_type')
                            ->options([
                                'image' => 'Imagen',
                                'code' => 'Codigo HTML (AdSense)',
                            ])
                            ->default('image')
                            ->inline(),
                    ]),
                
                FileUpload::make('image')
                    ->label('Imagen')
                    ->directory('images/advertisements')
                    ->disk('public')
                    ->visibility('public')
                    ->image()
                    ->maxSize(10240)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
                    ->visible(fn ($livewire) => $livewire->data['ad_type'] !== 'code'),
                
                TextInput::make('link')
                    ->label('URL de destino')
                    ->url(),
                
                Textarea::make('code')
                    ->label('Codigo HTML')
                    ->columnSpanFull(),
                
                Section::make('Programacion')
                    ->schema([
                        Toggle::make('is_active')
                            ->default(true),
                        DateTimePicker::make('start_date'),
                        DateTimePicker::make('end_date'),
                        TextInput::make('order')
                            ->numeric()
                            ->default(1),
                    ])->columns(4),
            ]);
    }
}
