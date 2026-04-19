<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'avatar' => $this->getAvatarUrl($this->avatar),
            'bio' => $this->bio,
            'email' => $this->email,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }

    private function getAvatarUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // If it's already a full URL, return as is
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Convert relative path to full URL
        return url('storage/' . $path);
    }
}
