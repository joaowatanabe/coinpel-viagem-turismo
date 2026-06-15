<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'trip_id'        => ['nullable', 'integer', 'exists:trips,id'],
            'price'          => ['required', 'numeric', 'min:0'],
            'includes_hotel' => ['boolean'],
            'includes_meals' => ['boolean'],
            'includes_guide' => ['boolean'],
            'max_people'     => ['required', 'integer', 'min:1'],
            'status'         => ['required', 'string', 'in:available,sold_out,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'O nome do pacote é obrigatório.',
            'name.max'            => 'O nome do pacote não pode ter mais de 255 caracteres.',
            'trip_id.exists'      => 'A viagem selecionada não existe.',
            'price.required'      => 'O preço do pacote é obrigatório.',
            'price.numeric'       => 'O preço do pacote deve ser um número.',
            'price.min'           => 'O preço do pacote não pode ser negativo.',
            'max_people.required' => 'A capacidade máxima de pessoas é obrigatória.',
            'max_people.integer'  => 'A capacidade de pessoas deve ser um valor inteiro.',
            'max_people.min'      => 'A capacidade deve ser de pelo menos 1 pessoa.',
            'status.required'     => 'O status é obrigatório.',
            'status.in'           => 'O status informado é inválido.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'includes_hotel' => $this->boolean('includes_hotel'),
            'includes_meals' => $this->boolean('includes_meals'),
            'includes_guide' => $this->boolean('includes_guide'),
        ]);
    }
}
