<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Trip;
use App\Http\Requests\StorePackageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    /**
     * Exibe a listagem de pacotes.
     */
    public function index()
    {
        $search = request('search');
        $driverName = DB::connection()->getDriverName();
        $likeOperator = $driverName === 'postgres' ? 'ilike' : 'like';

        $packagesQuery = Package::with(['trip'])
            ->when($search, function ($query, $search) use ($likeOperator) {
                $query->where('name', $likeOperator, "%{$search}%");
            })
            ->orderBy('created_at', 'desc');

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'packages' => $packagesQuery->get()
            ]);
        }

        $packages = $packagesQuery->paginate(12)->withQueryString();

        return view('packages.index', [
            'packages' => $packages,
            'search'   => $search,
            'trips'    => Trip::orderBy('name')->get(),
        ]);
    }

    /**
     * Cria um novo pacote.
     */
    public function store(StorePackageRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        $package = Package::create($data);

        return response()->json([
            'success' => true,
            'package' => $package->load(['trip']),
            'message' => 'Pacote criado com sucesso.'
        ], 201);
    }

    /**
     * Retorna os detalhes de um pacote.
     */
    public function show(Package $package): JsonResponse
    {
        return response()->json([
            'package' => $package->load(['trip'])
        ]);
    }

    /**
     * Atualiza um pacote.
     */
    public function update(StorePackageRequest $request, Package $package): JsonResponse
    {
        $data = $request->validated();
        $package->update($data);

        return response()->json([
            'success' => true,
            'package' => $package->fresh(['trip']),
            'message' => 'Pacote atualizado com sucesso.'
        ]);
    }

    /**
     * Exclui um pacote (Soft Delete).
     */
    public function destroy(Package $package): JsonResponse
    {
        $package->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pacote excluído com sucesso.'
        ]);
    }
}
