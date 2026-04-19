<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:authors,slug,' . $this->route('author')?->id,
            'email' => 'required|email|max:255|unique:authors,email,' . $this->route('author')?->id,
            'avatar' => 'nullable|string|regex:/^(https?:\/\/|images\/authors\/).+$/|max:255',
            'bio' => 'nullable|string|max:1000',
            'social_links' => 'nullable|array',
            'social_links.*' => 'string|max:255',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del autor es requerido',
            'name.string' => 'El nombre debe ser un texto válido',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            
            'slug.required' => 'El slug es requerido',
            'slug.unique' => 'Este slug ya está en uso',
            'slug.max' => 'El slug no puede exceder 255 caracteres',
            
            'email.required' => 'El email es requerido',
            'email.email' => 'El email debe ser un correo válido',
            'email.unique' => 'Este email ya está registrado',
            'email.max' => 'El email no puede exceder 255 caracteres',
            
            'avatar.string' => 'El avatar debe ser una URL o ruta de archivo válida',
            'avatar.regex' => 'El avatar debe ser una URL externa o una ruta del sistema de almacenamiento',
            'avatar.max' => 'El avatar no puede exceder 255 caracteres',
            
            'bio.string' => 'La biografía debe ser un texto válido',
            'bio.max' => 'La biografía no puede exceder 1000 caracteres',
            
            'social_links.array' => 'Los enlaces sociales deben ser un arreglo válido',
            'social_links.*.string' => 'Cada enlace social debe ser un texto válido',
            'social_links.*.max' => 'Cada enlace social no puede exceder 255 caracteres',
            
            'is_active.boolean' => 'El estado debe ser verdadero o falso',
        ];
    }
}
