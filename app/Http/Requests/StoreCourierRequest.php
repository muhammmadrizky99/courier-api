<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCourierRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:couriers,email'],
            'phone' => ['nullable', 'string', 'max:30', 'unique:couriers,phone'],
            'level' => ['required', 'integer', 'between:1,5'],
            'vehicle_type' => ['nullable', 'string', 'max:100'],
            'is_active' => ['sometimes', 'boolean'],
            'registered_at' => ['sometimes', 'date'],
        ];
    }
}
