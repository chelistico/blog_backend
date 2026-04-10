<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $articleId = $this->route('article')->id ?? $this->route('article');
        
        return [
            'title' => 'sometimes|required|string|max:255',
            'slug' => "nullable|string|max:255|unique:articles,slug,{$articleId}",
            'summary' => 'sometimes|required|string|max:500',
            'content' => 'sometimes|required|string',
            'main_image' => 'nullable|string',
            'embedded_images' => 'nullable|array',
            'embedded_images.*' => 'string',
            'video_url' => 'nullable|url',
            'author_id' => 'sometimes|required|exists:authors,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'published_at' => 'nullable|date',
            'is_published' => 'boolean',
            'read_time' => 'nullable|integer|min:1|max:120',
        ];
    }
}
