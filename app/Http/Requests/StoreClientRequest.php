<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Route parameter is 'customer' since the route is defined as Route::resource('customers', ...)
        $clientId = $this->route('customer')?->id ?? $this->route('client')?->id;

        return [
            'name'          => ['required', 'string', 'max:255'],
            'birth_date'    => ['required', 'date', 'before:today'],
            'cpf'           => ['required', 'string', 'max:14', 'unique:clients,cpf' . ($clientId ? ",{$clientId}" : '')],
            'zip_code'      => ['required', 'string', 'max:9'],
            'street'        => ['required', 'string', 'max:255'],
            'number'        => ['required', 'string', 'max:10'],
            'city'          => ['required', 'string', 'max:255'],
            'state'         => ['required', 'string', 'max:2'],
            'email'         => ['required', 'email', 'unique:clients,email' . ($clientId ? ",{$clientId}" : '')],
            'phone'         => ['required', 'string', 'max:20'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'O nome é obrigatório.',
            'birth_date.required'    => 'A data de nascimento é obrigatória.',
            'birth_date.date'        => 'A data de nascimento informada é inválida.',
            'birth_date.before'      => 'A data de nascimento deve ser no passado.',
            'cpf.required'           => 'O CPF é obrigatório.',
            'cpf.max'                => 'O CPF não pode ter mais de 14 caracteres.',
            'cpf.unique'             => 'Este CPF já está cadastrado.',
            'zip_code.required'      => 'O CEP é obrigatório.',
            'zip_code.max'           => 'O CEP não pode ter mais de 9 caracteres.',
            'street.required'        => 'A rua é obrigatória.',
            'number.required'        => 'O número é obrigatório.',
            'city.required'          => 'A cidade é obrigatória.',
            'state.required'         => 'O estado é obrigatório.',
            'state.max'              => 'O estado deve ter no máximo 2 caracteres.',
            'email.required'         => 'O e-mail é obrigatório.',
            'email.email'            => 'O e-mail informado é inválido.',
            'email.unique'           => 'Este e-mail já está cadastrado.',
            'phone.required'         => 'O telefone é obrigatório.',
            'profile_photo.image'    => 'O arquivo de foto de perfil deve ser uma imagem.',
            'profile_photo.max'      => 'A imagem não pode ser maior que 2MB.',
        ];
    }
}
