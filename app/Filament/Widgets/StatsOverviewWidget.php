<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Author;
use App\Models\Tag;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalArticles = Article::count();
        $publishedArticles = Article::where('is_published', true)->count();
        $totalAuthors = Author::count();
        $totalTags = Tag::count();
        $totalViews = Article::sum('views');
        
        return [
            Stat::make('Articulos Totales', $totalArticles)
                ->description('Total en el sistema')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),
            
            Stat::make('Articulos Publicados', $publishedArticles)
                ->description('Visibles en el frontend')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            
            Stat::make('Autores', $totalAuthors)
                ->description('Colaboradores activos')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
            
            Stat::make('Tags', $totalTags)
                ->description('Categorias disponibles')
                ->descriptionIcon('heroicon-m-tag')
                ->color('primary'),
            
            Stat::make('Vistas Totales', number_format($totalViews))
                ->description('En todos los articulos')
                ->descriptionIcon('heroicon-m-eye')
                ->color('gray'),
        ];
    }
}
