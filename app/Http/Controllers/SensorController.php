<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use App\Models\LeituraSensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
     * Recebe o JSON de sensores do colete e salva em leitura_sensor.
     *
     * Formato esperado do JSON:
     * {
     *   "codigo_serial": "SGE-0042",
     *   "timestamp": "2026-06-15T14:30:00",
     *   "sensores": {
     *     "frequencia_cardiaca": 72,
     *     "oxigenacao_spo2": 98,
     *     "temperatura_corporal": 36.5,
     *     "acelerometro": { "x": 0.12, "y": 9.81, "z": -0.05 },
     *     "giroscopio": { "x": 0.01, "y": -0.02, "z": 0.00 },
     *     "gps": { "latitude": -23.5505199, "longitude": -46.6333094 },
     *     "nivel_bateria": 87,
     *     "queda_detectada": false
     *   }
     * }
     */
    public function ingest(Request $request)
    {
        $validated = $request->validate([
            'codigo_serial' => 'required|string|exists:dispositivo,codigo_serial',
            'timestamp'     => 'nullable|date',
            'sensores'      => 'nullable|array',
        ]);

        $dispositivo = Dispositivo::where('codigo_serial', $validated['codigo_serial'])->first();

        if (!$dispositivo) {
            return response()->json(['error' => 'Dispositivo não encontrado.'], 404);
        }

        $sensores = $validated['sensores'] ?? [];
        $accel    = $sensores['acelerometro'] ?? [];
        $gyro     = $sensores['giroscopio'] ?? [];
        $gps      = $sensores['gps'] ?? [];

        $leitura = LeituraSensor::create([
            'id_dispositivo'      => $dispositivo->id_dispositivo,
            'id_usuario'          => $dispositivo->id_usuario,
            'payload'             => $request->all(),
            'frequencia_cardiaca' => $sensores['frequencia_cardiaca'] ?? null,
            'oxigenacao_spo2'     => $sensores['oxigenacao_spo2'] ?? null,
            'temperatura_corporal'=> $sensores['temperatura_corporal'] ?? null,
            'acelerometro_x'      => $accel['x'] ?? null,
            'acelerometro_y'      => $accel['y'] ?? null,
            'acelerometro_z'      => $accel['z'] ?? null,
            'giroscopio_x'        => $gyro['x'] ?? null,
            'giroscopio_y'        => $gyro['y'] ?? null,
            'giroscopio_z'        => $gyro['z'] ?? null,
            'latitude'            => $gps['latitude'] ?? null,
            'longitude'           => $gps['longitude'] ?? null,
            'nivel_bateria'       => $sensores['nivel_bateria'] ?? null,
            'queda_detectada'     => $sensores['queda_detectada'] ?? false,
            'timestamp_sensor'    => $validated['timestamp'] ?? now(),
        ]);

        // Atualizar estado do dispositivo com dados mais recentes
        $updateData = ['status_conexao' => 'Online', 'tempo_ultimo_sinal' => 'Agora'];
        if (isset($sensores['nivel_bateria'])) {
            $updateData['nivel_bateria'] = $sensores['nivel_bateria'];
        }
        $dispositivo->update($updateData);

        return response()->json([
            'message'  => 'Leitura registrada com sucesso.',
            'leitura'  => $leitura,
        ], 201);
    }

    /**
     * Retorna as últimas leituras de um dispositivo.
     */
    public function ultimas(int $dispositivoId)
    {
        $leituras = LeituraSensor::where('id_dispositivo', $dispositivoId)
                                  ->orderBy('recebido_em', 'desc')
                                  ->limit(50)
                                  ->get();

        return response()->json($leituras);
    }
}
