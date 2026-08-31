<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:25600', // Máximo 25MB
                'mimes:jpg,jpeg,png,webp,svg,gif,pdf,doc,docx,xls,xlsx,zip'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Debes seleccionar un archivo para subir.',
            'file.max' => 'El tamaño máximo permitido es de 25 MB.',
            'file.mimes' => 'El formato del archivo no es compatible.',
        ];
    }
}