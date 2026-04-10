<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;

class ArticlesByStatus extends ChartWidget
{
    protected int | string | array $columnSpan = 3;
    
    protected ?string $heading = 'Articulos por Estado';

    protected function getData(): array
    {
        $published = Article::where('is_published', true)->count();
        $drafts = Article::where('is_published', false)->count();
        
        return [
            'datasets' => [
                [
                    'data' => [$published, $drafts],
                    'backgroundColor' => ['#10b981', '#f59e0b'],
                ],
            ],
            'labels' => ['Publicados', 'Borradores'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
