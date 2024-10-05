<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
            'category' => ['required'],
            'entryDate' => ['required', 'date'],
            'amount' => ['required', 'numeric', 'gt:0']
        ];
    }

    public function messages(): array
    {
        return [
            'amount.regex' => 'Amount must be valid',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'amount' => trim($this->amount),
        ]);
    }
}
