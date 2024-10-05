<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:60'],
            'description' => ['required', 'string', 'max:255']
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => ucwords(trim($this->name)),
            'description' => trim($this->description),
        ]);
    }
}
