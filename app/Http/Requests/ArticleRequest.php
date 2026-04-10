<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'summary' => 'required|string',
            'content' => 'required|string',
            'main_image' => 'required|string|max:255',
            'embedded_images' => 'nullable|array',
            'embedded_images.*' => 'string',
            'video_url' => 'nullable|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'published_at' => 'nullable|date',
            'read_time' => 'nullable|integer|min:1',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es requerido',
            'title.max' => 'El título no puede exceder 255 caracteres',
            'summary.required' => 'El resumen es requerido',
            'content.required' => 'El contenido es requerido',
            'main_image.required' => 'La imagen principal es requerida',
            'author_id.required' => 'El autor es requerido',
            'author_id.exists' => 'El autor seleccionado no existe',
            'tags.*.exists' => 'Una o más etiquetas seleccionadas no existen',
        ];
    }
}
