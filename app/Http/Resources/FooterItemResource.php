<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FooterItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'section' => $this->section,
            'title' => $this->title,
            'content' => $this->content,
            'link_url' => $this->link_url,
            'order' => $this->order,
            'is_active' => $this->is_active,
        ];
    }
}
