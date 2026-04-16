<?php

namespace App\Filament\Resources\Articles\Pages;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure embedded_images is properly formatted as an array of strings
        if (isset($data['embedded_images']) && is_array($data['embedded_images'])) {
            $embedded = [];
            foreach ($data['embedded_images'] as $item) {
                // Extract the image path from repeater item
                if (is_array($item) && isset($item['image']) && !empty($item['image'])) {
                    $embedded[] = $item['image'];
                } elseif (is_string($item) && !empty($item)) {
                    $embedded[] = $item;
                }
            }
            $data['embedded_images'] = $embedded;
        }

        return $data;
    }
}



