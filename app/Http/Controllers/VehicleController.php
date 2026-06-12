<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $vehicles = Vehicle::when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('plate', 'ilike', "%{$search}%")
                      ->orWhere('model', 'ilike', "%{$search}%")
                      ->orWhereRaw('CAST(prefix AS TEXT) ILIKE ?', ["%{$search}%"]);
                });
            })
            ->when(request('vehicle_type'), function ($query, $type) {
                $query->where('vehicle_type', $type);
            })
            ->when(request('seat_type'), function ($query, $type) {
                $query->where('seat_type', $type);
            })
            ->orderBy('prefix')
            ->paginate(15)
            ->withQueryString();

        return view('vehicles.index', [
            'vehicles'     => $vehicles,
            'search'       => $search,
            'vehicleTypes' => Vehicle::VEHICLE_TYPES,
            'seatTypes'    => Vehicle::SEAT_TYPES,
            'amenities'    => Vehicle::AMENITIES,
        ]);
    }

    public function store(StoreVehicleRequest $request): JsonResponse
    {
        $vehicle = Vehicle::create($this->prepareData($request->validated()));

        return response()->json([
            'message' => 'Veículo cadastrado com sucesso.',
            'vehicle' => $vehicle,
        ], 201);
    }

    public function update(StoreVehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        $vehicle->update($this->prepareData($request->validated()));

        return response()->json([
            'message' => 'Veículo atualizado com sucesso.',
            'vehicle' => $vehicle->fresh(),
        ]);
    }

    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();

        return response()->json([
            'message' => 'Veículo excluído com sucesso.',
        ]);
    }

    private function prepareData(array $data): array
    {
        foreach (array_keys(Vehicle::AMENITIES) as $amenity) {
            $data[$amenity] = isset($data[$amenity]) && $data[$amenity];
        }

        return $data;
    }
}
