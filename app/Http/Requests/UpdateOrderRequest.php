<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            
            'status' => 'sometimes|required|string|in:pending,paid,shipped,canceled',
            'products' => 'sometimes|array',
            'products.*.id' => 'sometimes|required|exists:products,id',
            'products.*.quantity' => 'sometimes|required|integer|min:1',
        ];
    }
}
