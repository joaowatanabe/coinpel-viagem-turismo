<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Driver;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Get all active system notifications.
     */
    public function index(): JsonResponse
    {
        $today = now()->startOfDay();
        $sevenDaysLater = now()->addDays(7)->endOfDay();

        $newTrips = Trip::where('created_at', '>=', now()->subDay())
            ->get()
            ->map(function (Trip $trip) {
                return [
                    'type'       => 'new_trip',
                    'message'    => "Nova viagem criada: {$trip->name}",
                    'link'       => '/trips',
                    'date'       => $trip->created_at,
                ];
            });

        $inProgressTrips = Trip::where('status', Trip::STATUS_IN_PROGRESS)
            ->get()
            ->map(function (Trip $trip) {
                return [
                    'type'       => 'in_progress',
                    'message'    => "Viagem em andamento: {$trip->name}",
                    'link'       => '/trips',
                    'date'       => $trip->updated_at,
                ];
            });

        $driversAvailable = Driver::whereDoesntHave('trips', function ($query) use ($today, $sevenDaysLater) {
                $query->whereBetween('date', [$today, $sevenDaysLater]);
            })
            ->get()
            ->map(function (Driver $driver) {
                return [
                    'type'       => 'driver_available',
                    'message'    => "Motorista disponível: {$driver->name}",
                    'link'       => '/drivers',
                    'date'       => $driver->created_at,
                ];
            });

        $pendingPasswordUsers = User::where('must_change_password', true)
            ->get()
            ->map(function (User $user) {
                return [
                    'type'       => 'password_pending',
                    'message'    => "Usuário com troca de senha pendente: {$user->name}",
                    'link'       => '/users',
                    'date'       => $user->created_at,
                ];
            });

        $expiringContracts = Contract::whereBetween('end_date', [$today->format('Y-m-d'), $sevenDaysLater->format('Y-m-d')])
            ->get()
            ->map(function (Contract $contract) {
                return [
                    'type'       => 'contract_expiring',
                    'message'    => "Contrato {$contract->number} expirando em " . $contract->end_date->format('d/m/Y'),
                    'link'       => '/contracts',
                    'date'       => $contract->end_date,
                ];
            });

        $allNotifications = collect()
            ->concat($newTrips)
            ->concat($inProgressTrips)
            ->concat($driversAvailable)
            ->concat($pendingPasswordUsers)
            ->concat($expiringContracts)
            ->sortByDesc('date');

        $totalCount = $allNotifications->count();

        if (request()->boolean('countOnly')) {
            return response()->json([
                'count' => $totalCount,
            ]);
        }

        $offset = (int) request('offset', 0);
        $limit = (int) request('limit', 15);

        $sliced = $allNotifications
            ->slice($offset, $limit)
            ->map(function ($item) {
                return [
                    'type'       => $item['type'],
                    'message'    => $item['message'],
                    'link'       => $item['link'],
                    'created_at' => $item['date']->locale('pt_BR')->diffForHumans(),
                ];
            })
            ->values()
            ->all();

        $hasMore = ($offset + $limit) < $totalCount;
        $nextOffset = $offset + $limit;

        return response()->json([
            'count'      => $totalCount,
            'items'      => $sliced,
            'hasMore'    => $hasMore,
            'nextOffset' => $nextOffset,
        ]);
    }
}
