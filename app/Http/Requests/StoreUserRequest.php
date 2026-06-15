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
        $user = $this->route('user');
        $userId = $user instanceof \App\Models\User ? $user->id : $user;

        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', \Illuminate\Validation\Rule::unique('users', 'email')->ignore($userId)],
            'password'      => [$userId ? 'nullable' : 'required', 'string', 'min:6'],
            'is_blocked'    => [$userId ? 'nullable' : 'required', 'boolean'],
            'profile_photo' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg,webp'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'O nome é obrigatório.',
            'email.required'       => 'O e-mail é obrigatório.',
            'email.email'          => 'O e-mail informado é inválido.',
            'email.unique'         => 'Este e-mail já está cadastrado.',
            'password.required'    => 'A senha provisória é obrigatória.',
            'password.min'         => 'A senha deve ter no mínimo 6 caracteres.',
            'is_blocked.required'  => 'O status de bloqueio é obrigatório.',
            'profile_photo.image'  => 'A foto de perfil deve ser uma imagem.',
            'profile_photo.max'    => 'A foto de perfil não deve ter mais de 2MB.',
            'profile_photo.mimes'  => 'A foto de perfil deve ser do tipo: jpeg, png, jpg, webp.',
        ];
    }
}
