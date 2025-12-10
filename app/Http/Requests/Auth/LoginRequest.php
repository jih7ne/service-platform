<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Recaptcha;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
            'g-recaptcha-response' => ['required', new Recaptcha()],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'L\'email est obligatoire.',
            'email.email' => 'L\'email doit être valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'g-recaptcha-response.required' => 'Veuillez cocher la case reCAPTCHA.',
        ];
    }
}