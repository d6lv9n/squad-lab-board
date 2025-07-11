<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoardRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', 'min:1'],
            'description' => ['required', 'string', 'max:3000', 'min:1'],

            'tasks' => ['nullable', 'array', 'max:10'],
            'tasks.*.title' => ['required', 'string', 'max:255', 'min:1'],
            'tasks.*.description' => ['nullable', 'string', 'max:600'],

            'members' => ['nullable', 'array', 'max:10'],
            'members.*' => ['required', 'int', 'min:1']
        ];
    }
}
