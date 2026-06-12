<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(): View
    {
        $search = request('search');

        $users = User::when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                      ->orWhere('email', 'ilike', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('users.index', [
            'users'  => $users,
            'search' => $search,
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['must_change_password'] = true;

        $user = User::create($data);

        return response()->json([
            'message' => 'Usuário cadastrado com sucesso.',
            'user'    => $user,
        ], 201);
    }

    public function update(StoreUserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();

        if (Auth::id() === $user->id && (bool)$data['is_blocked']) {
            return response()->json([
                'errors' => [
                    'is_blocked' => ['Você não pode bloquear o seu próprio usuário.']
                ]
            ], 422);
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
            $data['must_change_password'] = true;
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json([
            'message' => 'Usuário atualizado com sucesso.',
            'user'    => $user->fresh(),
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        if (Auth::id() === $user->id) {
            return response()->json([
                'message' => 'Você não pode excluir o seu próprio usuário.'
            ], 422);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuário excluído com sucesso.',
        ]);
    }
}
