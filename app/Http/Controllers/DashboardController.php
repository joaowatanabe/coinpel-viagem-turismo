<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o painel administrativo (Dashboard).
     */
    public function index(): View
    {
        $today = today()->format('Y-m-d');

        // Query KPI statistics and sub-texts
        $tripsTotal = Trip::count();
        $tripsThisMonth = Trip::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $vehiclesTotal = Vehicle::count();
        $vehiclesAvailable = Vehicle::whereDoesntHave('trips', function ($query) use ($today) {
            $query->whereDate('date', $today);
        })->count();

        $driversTotal = Driver::count();
        $driversWithTripToday = Driver::whereHas('trips', function ($query) use ($today) {
            $query->whereDate('date', $today);
        })->count();

        $adminsTotal = User::count();
        $adminsPendingPassword = User::where('must_change_password', true)->count();

        // Query upcoming trips (max 5 rows)
        $upcomingTrips = Trip::where('date', '>=', $today)
            ->orderBy('date')
            ->take(5)
            ->with(['driver', 'vehicle'])
            ->get();

        // Query trips grouped by status
        $tripsByStatus = Trip::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Calculate estimated revenue of non-cancelled trips
        $estimatedRevenue = Trip::where('status', '!=', Trip::STATUS_CANCELLED)
            ->sum(DB::raw('ticket_price * passenger_count'));

        // Query recent trips activity (max 5 rows)
        $recentTrips = Trip::with('creator')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'tripsTotal'            => $tripsTotal,
            'tripsThisMonth'        => $tripsThisMonth,
            'vehiclesTotal'         => $vehiclesTotal,
            'vehiclesAvailable'     => $vehiclesAvailable,
            'driversTotal'          => $driversTotal,
            'driversWithTripToday'  => $driversWithTripToday,
            'adminsTotal'           => $adminsTotal,
            'adminsPendingPassword' => $adminsPendingPassword,
            'upcomingTrips'         => $upcomingTrips,
            'tripsByStatus'         => $tripsByStatus,
            'estimatedRevenue'      => $estimatedRevenue,
            'recentTrips'           => $recentTrips,
        ]);
    }
}
