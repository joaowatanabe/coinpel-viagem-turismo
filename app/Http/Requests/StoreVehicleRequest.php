<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Vehicle;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prefix'       => ['required', 'integer', 'min:1'],
            'plate'        => ['required', 'string', 'max:20'],
            'model'        => ['required', 'string', 'max:255'],
            'chassis'      => ['nullable', 'string', 'max:100'],
            'capacity'     => ['required', 'integer', 'min:1'],
            'vehicle_type' => ['required', 'string', 'in:' . implode(',', array_keys(Vehicle::VEHICLE_TYPES))],
            'seat_type'    => ['required', 'string', 'in:' . implode(',', array_keys(Vehicle::SEAT_TYPES))],
            'year'         => ['required', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'has_wifi'     => ['nullable', 'boolean'],
            'has_wc'       => ['nullable', 'boolean'],
            'has_outlet'   => ['nullable', 'boolean'],
            'has_ac'       => ['nullable', 'boolean'],
            'has_fridge'   => ['nullable', 'boolean'],
            'has_heating'  => ['nullable', 'boolean'],
            'has_video'    => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'prefix.required'       => 'O prefixo é obrigatório.',
            'prefix.integer'        => 'O prefixo deve ser um número inteiro.',
            'prefix.min'            => 'O prefixo deve ser maior que zero.',
            'plate.required'        => 'A placa é obrigatória.',
            'plate.max'             => 'A placa não pode ter mais de 20 caracteres.',
            'model.required'        => 'O modelo é obrigatório.',
            'chassis.max'           => 'O chassi não pode ter mais de 100 caracteres.',
            'capacity.required'     => 'A capacidade é obrigatória.',
            'capacity.integer'      => 'A capacidade deve ser um número inteiro.',
            'capacity.min'          => 'A capacidade deve ser de no mínimo 1 passageiro.',
            'vehicle_type.required' => 'O tipo de veículo é obrigatório.',
            'vehicle_type.in'       => 'O tipo de veículo informado é inválido.',
            'seat_type.required'    => 'O tipo de bancada é obrigatório.',
            'seat_type.in'          => 'O tipo de bancada informado é inválido.',
            'year.required'         => 'O ano é obrigatório.',
            'year.integer'          => 'O ano deve ser um número inteiro.',
            'year.min'              => 'O ano informado é inválido.',
            'year.max'              => 'O ano não pode ser maior que o próximo ano.',
        ];
    }
}
