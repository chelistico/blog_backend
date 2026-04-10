<?php

namespace App\Filament\Resources\Articles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('main_image')
                    ->label('Image'),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('author.name')
                    ->searchable()
                    ->label('Author'),
                TextColumn::make('tags.name')
                    ->label('Tags')
                    ->badge()
                    ->searchable(),
                TextColumn::make('published_at')
                    ->date()
                    ->sortable(),
                TextColumn::make('views')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_published')
                    ->boolean()
                    ->label('Published'),
            ])
            ->filters([
                SelectFilter::make('author_id')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->label('Author'),
                SelectFilter::make('is_published')
                    ->options([
                        '1' => 'Published',
                        '0' => 'Draft',
                    ])
                    ->label('Status'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
