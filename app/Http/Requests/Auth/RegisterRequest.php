<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Allow anyone to register
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, string|array>
     */
    public function rules(): array
    {
        return [
            'firstName'     => 'required|min:2|max:50',
            'lastName'      => 'required|min:2|max:50',
            'email'         => 'required|email|unique:utilisateurs,email',
            'password'      => 'required|min:8',
            'telephone'     => 'required|min:10|max:20',
            'dateNaissance' => 'required|date',
        ];
    }
}
