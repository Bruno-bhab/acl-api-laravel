<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class IndexUserRequest extends FormRequest
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
            'totalPerPage' => [
                'string',
                'min:1',
                'max:255',
            ],
            'page' => [
                'string',
                'min:1',
                'max:20',
            ],
            'filter' => [
                'string',
                'min:3',
                'max:20',
            ],
        ];
    }
}
