<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Trip;

class StoreTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'            => ['required', 'string', 'max:255'],
            'rule'            => ['required', 'string', 'max:100'],
            'date'            => ['required', 'date'],
            'departure_time'  => ['required', 'date_format:H:i'],
            'origin'          => ['required', 'string', 'max:255'],
            'destination'     => ['required', 'string', 'max:255'],
            'ticket_price'    => ['required', 'numeric', 'min:0'],
            'passenger_count' => ['required', 'integer', 'min:1'],
            'status'          => ['required', 'string', 'in:' . implode(',', array_keys(Trip::STATUSES))],
            'vehicle_id'      => ['required', 'integer', 'exists:vehicles,id'],
            'driver_id'       => ['required', 'integer', 'exists:drivers,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'            => 'O nome da viagem é obrigatório.',
            'rule.required'            => 'A regra da viagem é obrigatória.',
            'date.required'            => 'A data da viagem é obrigatória.',
            'date.date'                => 'A data informada é inválida.',
            'departure_time.required'  => 'O horário de saída é obrigatório.',
            'departure_time.date_format' => 'O horário deve estar no formato HH:MM.',
            'origin.required'          => 'A origem é obrigatória.',
            'destination.required'     => 'O destino é obrigatório.',
            'ticket_price.required'    => 'O valor da passagem é obrigatório.',
            'ticket_price.numeric'     => 'O valor da passagem deve ser um número.',
            'ticket_price.min'         => 'O valor da passagem não pode ser negativo.',
            'passenger_count.required' => 'O número de passageiros é obrigatório.',
            'passenger_count.integer'  => 'O número de passageiros deve ser inteiro.',
            'passenger_count.min'      => 'Deve haver ao menos 1 passageiro.',
            'status.required'          => 'O status é obrigatório.',
            'status.in'                => 'O status informado é inválido.',
            'vehicle_id.required'      => 'Selecione um veículo.',
            'vehicle_id.exists'        => 'O veículo selecionado não existe.',
            'driver_id.required'       => 'Selecione um motorista.',
            'driver_id.exists'         => 'O motorista selecionado não existe.',
        ];
    }
}
