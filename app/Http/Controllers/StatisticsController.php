<?php
/**
 * @file StatisticsController.php
 * @brief Controller responsável por calcular e prover os dados estatísticos para a view de Estatísticas.
 */

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Trip;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    /**
     * Exibe o painel de estatísticas com os principais indicadores e viagens recentes.
     *
     * @return View
     */
    public function index(): View
    {
        $totalTrips = Trip::count();
        $tripsLast30Days = Trip::where('date', '>=', now()->subDays(30))->count();

        $activeDriversCount = Driver::count();

        $vehiclesCount = Vehicle::count();

        $estimatedRevenue = Trip::selectRaw('SUM(ticket_price * passenger_count) as revenue')->value('revenue') ?? 0.00;

        $recentTrips = Trip::with(['driver', 'vehicle'])
            ->orderByDesc('date')
            ->orderByDesc('departure_time')
            ->limit(10)
            ->get();

        $statusCounts = Trip::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        $completedCount = $statusCounts[Trip::STATUS_COMPLETED] ?? 0;
        $inProgressCount = $statusCounts[Trip::STATUS_IN_PROGRESS] ?? 0;
        $cancelledCount = $statusCounts[Trip::STATUS_CANCELLED] ?? 0;
        $scheduledCount = $statusCounts[Trip::STATUS_SCHEDULED] ?? 0;

        return view('statistics.index', compact(
            'totalTrips',
            'tripsLast30Days',
            'activeDriversCount',
            'vehiclesCount',
            'estimatedRevenue',
            'recentTrips',
            'completedCount',
            'inProgressCount',
            'cancelledCount',
            'scheduledCount'
        ));
    }
}
