<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDriverRequest;
use App\Models\Driver;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{
    public function index(): View
    {
        $search       = request('search');
        $filterName   = request('name');
        $filterReg    = request('registration');

        $drivers = Driver::when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                      ->orWhere('registration', 'ilike', "%{$search}%")
                      ->orWhere('cpf', 'ilike', "%{$search}%")
                      ->orWhere('email', 'ilike', "%{$search}%");
                });
            })
            ->when($filterName, fn($q, $v) => $q->where('name', 'ilike', "%{$v}%"))
            ->when($filterReg,  fn($q, $v) => $q->where('registration', 'ilike', "%{$v}%"))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('drivers.index', [
            'drivers' => $drivers,
            'search'  => $search,
        ]);
    }

    public function store(StoreDriverRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo_path'] = $request->file('profile_photo')->store('drivers', 'public');
        }

        $driver = Driver::create($data);

        return response()->json([
            'message' => 'Motorista cadastrado com sucesso.',
            'driver'  => $driver,
        ], 201);
    }

    public function update(StoreDriverRequest $request, Driver $driver): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('profile_photo')) {
            if ($driver->profile_photo_path) {
                Storage::disk('public')->delete($driver->profile_photo_path);
            }
            $data['profile_photo_path'] = $request->file('profile_photo')->store('drivers', 'public');
        }

        $driver->update($data);

        return response()->json([
            'message' => 'Motorista atualizado com sucesso.',
            'driver'  => $driver->fresh(),
        ]);
    }

    public function show(Driver $driver): JsonResponse
    {
        return response()->json([
            'driver' => $driver,
        ]);
    }

    public function destroyPhoto(Driver $driver): JsonResponse
    {
        if ($driver->profile_photo_path) {
            Storage::disk('public')->delete($driver->profile_photo_path);
            $driver->update(['profile_photo_path' => null]);
        }
        return response()->json(['success' => true, 'message' => 'Foto removida.']);
    }

    public function destroy(Driver $driver): JsonResponse
    {
        $driver->delete();

        return response()->json([
            'message' => 'Motorista excluído com sucesso.',
        ]);
    }
}
