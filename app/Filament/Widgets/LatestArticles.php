<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestArticles extends TableWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Article::query()
            ->with('author')
            ->latest()
            ->limit(10);
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): \Illuminate\Database\Eloquent\Builder => $this->getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('author.name'),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean()
                    ->label('Publicado'),
                Tables\Columns\TextColumn::make('views')
                    ->numeric(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                //
            ]);
    }
}
