<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo_path'] = $request->file('profile_photo')->store('users', 'public');
        }

        $user = User::create($data);

        return response()->json([
            'message' => 'Usuário cadastrado com sucesso.',
            'user'    => $user,
        ], 201);
    }

    public function update(StoreUserRequest $request, User $user): JsonResponse
    {
        $data = $request->validated();

        if (Auth::id() === $user->id && (bool) $data['is_blocked']) {
            return response()->json([
                'errors' => ['is_blocked' => ['Você não pode bloquear o seu próprio usuário.']]
            ], 422);
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
            $data['must_change_password'] = true;
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $data['profile_photo_path'] = $request->file('profile_photo')->store('users', 'public');
        }

        $user->update($data);

        return response()->json([
            'message' => 'Usuário atualizado com sucesso.',
            'user'    => $user->fresh(),
        ]);
    }

    public function toggleBlock(Request $request, User $user): JsonResponse
    {
        if (Auth::id() === $user->id) {
            return response()->json([
                'message' => 'Você não pode bloquear o seu próprio usuário.'
            ], 422);
        }

        $block = $request->boolean('block');
        $user->update(['is_blocked' => $block]);
        $label = $block ? 'bloqueado' : 'desbloqueado';

        return response()->json([
            'message' => "Usuário {$label} com sucesso.",
            'user'    => $user->fresh(),
        ]);
    }

    public function destroyPhoto(User $user): JsonResponse
    {
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->update(['profile_photo_path' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Foto de perfil removida com sucesso.'
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
