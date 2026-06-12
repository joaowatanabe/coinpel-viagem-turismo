<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email' . ($userId ? ",{$userId}" : '')],
            'password'   => [$userId ? 'nullable' : 'required', 'string', 'min:6'],
            'is_blocked' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'O nome é obrigatório.',
            'email.required'      => 'O e-mail é obrigatório.',
            'email.email'         => 'O e-mail informado é inválido.',
            'email.unique'        => 'Este e-mail já está cadastrado.',
            'password.required'   => 'A senha provisória é obrigatória.',
            'password.min'        => 'A senha deve ter no mínimo 6 caracteres.',
            'is_blocked.required' => 'O status de bloqueio é obrigatório.',
        ];
    }
}
