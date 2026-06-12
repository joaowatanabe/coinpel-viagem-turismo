<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TripController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $trips = Trip::with(['vehicle', 'driver'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                      ->orWhere('origin', 'ilike', "%{$search}%")
                      ->orWhere('destination', 'ilike', "%{$search}%");
                });
            })
            ->orderByDesc('date')
            ->orderByDesc('departure_time')
            ->paginate(15)
            ->withQueryString();

        return view('trips.index', compact('trips', 'search'));
    }

    public function create(): View
    {
        $vehicles = Vehicle::orderBy('prefix')->get(['id', 'prefix', 'model']);
        $drivers  = Driver::orderBy('name')->get(['id', 'name', 'registration']);

        return view('trips.create', compact('vehicles', 'drivers'));
    }

    public function store(StoreTripRequest $request): RedirectResponse
    {
        Trip::create([
            ...$request->validated(),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('trips.index')
            ->with('status', 'Viagem criada com sucesso.');
    }

    public function edit(Trip $trip): View
    {
        $vehicles = Vehicle::orderBy('prefix')->get(['id', 'prefix', 'model']);
        $drivers  = Driver::orderBy('name')->get(['id', 'name', 'registration']);

        return view('trips.edit', compact('trip', 'vehicles', 'drivers'));
    }

    public function update(StoreTripRequest $request, Trip $trip): RedirectResponse
    {
        $trip->update($request->validated());

        return redirect()->route('trips.index')
            ->with('status', 'Viagem atualizada com sucesso.');
    }

    public function destroy(Trip $trip): RedirectResponse
    {
        $trip->delete();

        return redirect()->route('trips.index')
            ->with('status', 'Viagem excluída com sucesso.');
    }
}
