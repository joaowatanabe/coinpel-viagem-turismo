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
    public function index()
    {
        $tripsCount        = \App\Models\Trip::count();
        $tripsThisMonth    = \App\Models\Trip::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count();

        $vehiclesTotal     = \App\Models\Vehicle::count();

        $driversTotal      = \App\Models\Driver::count();
        $driversWithTrip   = \App\Models\Trip::whereDate('date', today())
                                ->whereNotNull('driver_id')
                                ->distinct('driver_id')
                                ->count('driver_id');

        $adminsTotal       = \App\Models\User::count();
        $adminsPending     = \App\Models\User::where('must_change_password', true)->count();

        $upcomingTrips     = \App\Models\Trip::with(['driver', 'vehicle'])
                                ->where('date', '>=', today())
                                ->orderBy('date')
                                ->orderBy('departure_time')
                                ->take(5)
                                ->get();

        $tripsCompleted    = \App\Models\Trip::where('status', 'completed')->count();
        $tripsInProgress   = \App\Models\Trip::where('status', 'in_progress')->count();
        $tripsCancelled    = \App\Models\Trip::where('status', 'cancelled')->count();

        $estimatedRevenue  = \App\Models\Trip::where('status', '!=', 'cancelled')
                                ->selectRaw('SUM(ticket_price * passenger_count) as total')
                                ->value('total') ?? 0;

        $recentTrips       = \App\Models\Trip::with('driver')
                                ->latest()
                                ->take(5)
                                ->get();

        return view('dashboard', compact(
            'tripsCount',
            'tripsThisMonth',
            'vehiclesTotal',
            'driversTotal',
            'driversWithTrip',
            'adminsTotal',
            'adminsPending',
            'upcomingTrips',
            'tripsCompleted',
            'tripsInProgress',
            'tripsCancelled',
            'estimatedRevenue',
            'recentTrips'
        ));
    }
}
