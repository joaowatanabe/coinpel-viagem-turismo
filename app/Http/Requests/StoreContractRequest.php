<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $contract = $this->route('contract');
        $contractId = $contract instanceof \App\Models\Contract ? $contract->id : $contract;

        return [
            'number'      => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('contracts', 'number')->ignore($contractId)],
            'client_id'   => ['nullable', 'integer', 'exists:clients,id'],
            'trip_id'     => ['nullable', 'integer', 'exists:trips,id'],
            'description' => ['nullable', 'string'],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            'value'       => ['required', 'numeric', 'min:0'],
            'status'      => ['required', 'string', 'in:active,expired,cancelled'],
        ];
    }

    public function messages(): array
    {
        return [
            'number.required'      => 'O número do contrato é obrigatório.',
            'number.unique'        => 'Este número de contrato já está cadastrado.',
            'client_id.exists'     => 'O cliente selecionado não existe.',
            'trip_id.exists'       => 'A viagem selecionada não existe.',
            'start_date.required'  => 'A data de início é obrigatória.',
            'start_date.date'      => 'A data de início é inválida.',
            'end_date.required'    => 'A data de término é obrigatória.',
            'end_date.date'        => 'A data de término é inválida.',
            'end_date.after_or_equal' => 'A data de término deve ser posterior ou igual à data de início.',
            'value.required'       => 'O valor é obrigatório.',
            'value.numeric'        => 'O valor deve ser numérico.',
            'value.min'            => 'O valor não pode ser negativo.',
            'status.required'      => 'O status é obrigatório.',
            'status.in'            => 'O status informado é inválido.',
        ];
    }
}
