<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Client;
use App\Models\Trip;
use App\Http\Requests\StoreContractRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ContractController extends Controller
{
    /**
     * Exibe a listagem de contratos.
     */
    public function index()
    {
        $search = request('search');
        $driverName = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        $likeOperator = $driverName === 'postgres' ? 'ilike' : 'like';

        $contractsQuery = Contract::with(['client', 'trip'])
            ->when($search, function ($query, $search) use ($likeOperator) {
                $query->where(function ($q) use ($search, $likeOperator) {
                    $q->where('number', $likeOperator, "%{$search}%")
                      ->orWhereHas('client', function ($cq) use ($search, $likeOperator) {
                          $cq->where('name', $likeOperator, "%{$search}%");
                      });
                });
            })
            ->orderBy('created_at', 'desc');

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'contracts' => $contractsQuery->get()
            ]);
        }

        $contracts = $contractsQuery->paginate(15)->withQueryString();

        // Gerar sugestão automática de número de contrato
        $year = date('Y');
        $count = Contract::withTrashed()->whereYear('created_at', $year)->count() + 1;
        $nextNumber = "CONT-{$year}-" . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('contracts.index', [
            'contracts'  => $contracts,
            'search'     => $search,
            'clients'    => Client::orderBy('name')->get(),
            'trips'      => Trip::orderBy('name')->get(),
            'nextNumber' => $nextNumber,
        ]);
    }

    /**
     * Cria um novo contrato.
     */
    public function store(StoreContractRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        $contract = Contract::create($data);

        return response()->json([
            'success'  => true,
            'contract' => $contract->load(['client', 'trip']),
            'message'  => 'Contrato criado com sucesso.'
        ], 201);
    }

    /**
     * Retorna os detalhes de um contrato em JSON.
     */
    public function show(Contract $contract): JsonResponse
    {
        return response()->json([
            'contract' => $contract->load(['client', 'trip'])
        ]);
    }

    /**
     * Atualiza um contrato existente.
     */
    public function update(StoreContractRequest $request, Contract $contract): JsonResponse
    {
        $data = $request->validated();
        $contract->update($data);

        return response()->json([
            'success'  => true,
            'contract' => $contract->fresh(['client', 'trip']),
            'message'  => 'Contrato atualizado com sucesso.'
        ]);
    }

    /**
     * Exclui um contrato (Soft Delete).
     */
    public function destroy(Contract $contract): JsonResponse
    {
        $contract->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contrato excluído com sucesso.'
        ]);
    }
}
