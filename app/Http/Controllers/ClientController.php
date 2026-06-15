<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $clients = Client::when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                      ->orWhere('email', 'ilike', "%{$search}%")
                      ->orWhere('cpf', 'ilike', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('clients.index', [
            'clients' => $clients,
            'search'  => $search,
        ]);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo_path'] = $request->file('profile_photo')->store('clients', 'public');
        }

        $client = Client::create($data);

        return response()->json([
            'message' => 'Cliente cadastrado com sucesso.',
            'client'  => $client,
        ], 201);
    }

    public function show(Client $customer): JsonResponse
    {
        return response()->json([
            'id'                => $customer->id,
            'name'              => $customer->name,
            'email'             => $customer->email,
            'phone'             => $customer->phone,
            'cpf'               => $customer->cpf,
            'birth_date'        => $customer->birth_date?->format('d/m/Y'),
            'zip_code'          => $customer->zip_code,
            'street'            => $customer->street,
            'number'            => $customer->number,
            'city'              => $customer->city,
            'state'             => $customer->state,
            'profile_photo_url' => $customer->profile_photo_path
                ? asset('storage/' . $customer->profile_photo_path)
                : null,
            'initials'          => strtoupper(mb_substr($customer->name, 0, 1)) .
                                   strtoupper(mb_substr(strstr($customer->name.' ',' '), 1, 1)),
        ]);
    }

    public function update(StoreClientRequest $request, Client $customer): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_photo')) {
            if ($customer->profile_photo_path) {
                Storage::disk('public')->delete($customer->profile_photo_path);
            }
            $data['profile_photo_path'] = $request->file('profile_photo')->store('clients', 'public');
        }

        $customer->update($data);

        return response()->json([
            'message' => 'Cliente atualizado com sucesso.',
            'client'  => $customer->fresh(),
        ]);
    }

    public function destroyPhoto(Client $client): JsonResponse
    {
        if ($client->profile_photo_path) {
            Storage::disk('public')->delete($client->profile_photo_path);
            $client->update(['profile_photo_path' => null]);
        }
        return response()->json(['success' => true, 'message' => 'Foto removida.']);
    }

    public function destroy(Client $customer): JsonResponse
    {
        $customer->delete();

        return response()->json([
            'message' => 'Cliente excluído com sucesso.',
        ]);
    }
}
