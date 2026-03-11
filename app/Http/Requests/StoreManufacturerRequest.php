<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreManufacturerRequest extends FormRequest
{
    /**
     * Determine se o usuário está autorizado a fazer essa requisição.
     * Como a rota já será protegida pelo middleware JWT, podemos retornar true.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Obrigatório, texto, máximo 255 chars e deve ser único na tabela manufacturers
            'name' => 'required|string|max:255|unique:manufacturers,name',
        ];
    }

    // Opcional: Traduzindo as mensagens de erro
    public function messages(): array
    {
        return [
            'name.required' => 'O nome do fabricante é obrigatório.',
            'name.unique' => 'Este fabricante já está cadastrado.',
        ];
    }
}
