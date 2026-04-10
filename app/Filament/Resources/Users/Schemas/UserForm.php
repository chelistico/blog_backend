<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('role')
                    ->options([
                        'admin' => 'Administrador',
                        'editor' => 'Editor',
                        'author' => 'Autor',
                    ])
                    ->default('author')
                    ->required(),
                Toggle::make('is_admin')
                    ->label('Es Admin'),
                DateTimePicker::make('email_verified_at')
                    ->label('Email verificado'),
                TextInput::make('password')
                    ->password()
                    ->nullable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->confirmed(),
            ]);
    }
}
