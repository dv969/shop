<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartGetCartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|integer', // Добавляем валидацию для user_id
        ];
    }
}
