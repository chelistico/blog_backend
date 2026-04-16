<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content' => $this->content,
            'main_image' => $this->getImageUrl($this->main_image),
            'embedded_images' => $this->convertEmbeddedImages($this->embedded_images ?? []),
            'video_url' => $this->video_url,
            'author' => new AuthorResource($this->whenLoaded('author')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'published_at' => $this->published_at?->toIso8601String(),
            'read_time' => $this->read_time,
            'views' => $this->views,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }

    private function getImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // If it's already a full URL, return as-is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Convert relative path to storage URL
        return url('storage/' . $path);
    }

    private function convertEmbeddedImages(array $images): array
    {
        return array_filter(array_map(function($image) {
            // If it's a string, process it directly
            if (is_string($image) && !empty($image)) {
                return $this->getImageUrl($image);
            }
            // If it's an array, extract the first non-empty value
            if (is_array($image)) {
                foreach ($image as $value) {
                    if (!empty($value) && is_string($value)) {
                        return $this->getImageUrl($value);
                    }
                }
            }
            return null;
        }, $images));
    }
}
