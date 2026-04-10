<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;

class PopularArticles extends ChartWidget
{
    protected int | string | array $columnSpan = 3;
    
    protected ?string $heading = 'Articulos Populares';

    protected function getData(): array
    {
        $articles = Article::orderByDesc('views')
            ->limit(5)
            ->get();
        
        return [
            'datasets' => [
                [
                    'label' => 'Vistas',
                    'data' => $articles->pluck('views')->toArray(),
                    'backgroundColor' => [
                        '#f59e0b',
                        '#3b82f6',
                        '#10b981',
                        '#6366f1',
                        '#ec4899',
                    ],
                ],
            ],
            'labels' => $articles->pluck('title')->map(fn ($t) => substr($t, 0, 20) . '...')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
