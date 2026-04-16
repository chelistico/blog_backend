<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informacion basica')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->maxLength(255),
                        TextInput::make('summary')
                            ->required()
                            ->maxLength(500),
                        Select::make('author_id')
                            ->relationship('author', 'name')
                            ->required()
                            ->searchable(),
                        Select::make('tags')
                            ->relationship('tags', 'name')
                            ->multiple()
                            ->searchable(),
                    ])->columns(2),
                
                Section::make('Contenido')
                    ->schema([
                        RichEditor::make('content')
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('images/articles'),
                    ]),
                
                Section::make('Multimedia')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        FileUpload::make('main_image')
                            ->label('Imagen Principal')
                            ->directory('images/articles')
                            ->disk('public')
                            ->visibility('public')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
                            ->maxSize(10240)
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('video_url')
                            ->label('Video URL (YouTube/Vimeo)')
                            ->url(),
                        Repeater::make('embedded_images')
                            ->label('Imagenes Embedidas')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Imagen')
                                    ->directory('images/articles/embedded')
                                    ->disk('public')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                    ->maxSize(10240)
                            ])
                            ->maxItems(20)
                            ->collapsible()
                            ->collapsed(false)
                            ->addActionLabel('Agregar Imagen'),
                    ]),
                
                Section::make('Publicacion')
                    ->schema([
                        Toggle::make('is_published')
                            ->default(false)
                            ->label('Publicado'),
                        DateTimePicker::make('published_at')
                            ->label('Fecha de publicacion'),
                        TextInput::make('read_time')
                            ->numeric()
                            ->suffix('minutos'),
                    ])->columns(3),
            ]);
    }
}
