<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourierRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255', Rule::unique('couriers', 'email')->ignore($this->courier)],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30', Rule::unique('couriers', 'phone')->ignore($this->courier)],
            'level' => ['sometimes', 'required', 'integer', 'between:1,5'],
            'vehicle_type' => ['sometimes', 'nullable', 'string', 'max:100'],
            'is_active' => ['sometimes', 'boolean'],
            'registered_at' => ['sometimes', 'date'],
        ];
    }
}
