<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManufacturerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Pegamos o ID do fabricante que está sendo editado através da URL da rota
        $manufacturerId = $this->route('manufacturer')->id ?? $this->route('manufacturer');

        return [
            'name' => 'required|string|max:255|unique:manufacturers,name,' . $manufacturerId,
        ];
    }
}
