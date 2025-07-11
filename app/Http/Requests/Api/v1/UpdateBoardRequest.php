<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // From middleware CheckToken
        $userId = request()->user_id;

        $board = $this->route('board');

        return $board && $userId === $board?->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // 'title' => ['required', 'string', 'max:255', 'min:1'],
            // 'description' => ['required', 'string', 'max:3000', 'min:1'],
        ];
    }
}
