<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use Illuminate\Http\Request;

class DispositivoController extends Controller
{
    /**
     * Lista todos os dispositivos.
     */
    public function index()
    {
        $dispositivos = Dispositivo::with('usuario')->get();
        return response()->json($dispositivos);
    }

    /**
     * Cria um novo dispositivo (com dados zerados, preparado para o JSON do colete).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_serial' => 'required|string|max:50|unique:dispositivo,codigo_serial',
            'id_usuario'    => 'nullable|exists:usuario,id_usuario',
        ]);

        $dispositivo = Dispositivo::create([
            'codigo_serial'      => $validated['codigo_serial'],
            'versao_firmware'    => null,
            'nivel_bateria'      => null,
            'tipo_conexao'       => null,
            'status_conexao'     => 'Offline',
            'tempo_ultimo_sinal' => '—',
            'id_usuario'         => $validated['id_usuario'] ?? null,
        ]);

        return response()->json($dispositivo->load('usuario'), 201);
    }

    /**
     * Exibe um dispositivo específico.
     */
    public function show(int $id)
    {
        $dispositivo = Dispositivo::with('usuario')->where('id_dispositivo', $id)->firstOrFail();
        return response()->json($dispositivo);
    }

    /**
     * Atualiza um dispositivo (firmware, status, etc.).
     */
    public function update(Request $request, int $id)
    {
        $dispositivo = Dispositivo::where('id_dispositivo', $id)->firstOrFail();

        $validated = $request->validate([
            'versao_firmware'   => 'sometimes|string|max:20',
            'nivel_bateria'     => 'sometimes|integer|min:0|max:100',
            'tipo_conexao'      => 'sometimes|string|max:20',
            'status_conexao'    => 'sometimes|string|in:Online,Offline',
            'tempo_ultimo_sinal'=> 'sometimes|string|max:30',
            'id_usuario'        => 'sometimes|nullable|exists:usuario,id_usuario',
        ]);

        $dispositivo->update($validated);
        return response()->json($dispositivo->load('usuario'));
    }

    /**
     * Remove um dispositivo.
     */
    public function destroy(int $id)
    {
        $dispositivo = Dispositivo::where('id_dispositivo', $id)->firstOrFail();
        $dispositivo->delete();
        return response()->json(['message' => 'Dispositivo removido com sucesso.']);
    }
}

