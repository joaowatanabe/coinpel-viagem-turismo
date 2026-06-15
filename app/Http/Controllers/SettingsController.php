<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Exibe a página de configurações.
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('settings.index', compact('settings'));
    }

    /**
     * Atualiza as configurações via AJAX/Fetch.
     */
    public function update(Request $request): JsonResponse
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Normaliza booleanos que podem vir como true/false (tipos reais do JS) para strings
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            
            Setting::set($key, $value);
        }

        return response()->json([
            'success' => true,
            'message' => 'Configurações salvas!'
        ]);
    }
}
