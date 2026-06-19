<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use App\Models\LeituraSensor;
use App\Models\EventoSaude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * Recebe webhooks externos (ex: do ESP32).
     */
    public function handle(Request $request)
    {
        // Validação básica do payload
        $validated = $request->validate([
            'codigo_serial' => 'required|string',
            'timestamp'     => 'nullable|date',
            'sensores'      => 'nullable|array',
        ]);

        $dispositivo = Dispositivo::where('codigo_serial', $validated['codigo_serial'])->first();

        if (!$dispositivo) {
            Log::warning('Webhook recebido para dispositivo não encontrado: ' . $validated['codigo_serial']);
            return response()->json(['error' => 'Dispositivo não encontrado.'], 404);
        }

        $sensores = $validated['sensores'] ?? [];
        $accel    = $sensores['acelerometro'] ?? [];
        $gyro     = $sensores['giroscopio'] ?? [];
        $gps      = $sensores['gps'] ?? [];

        // Registra a leitura do sensor
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

        // Verifica anomalias para criar um Evento de Saúde
        $categoria = null;
        $descricao = null;

        if (isset($sensores['queda_detectada']) && $sensores['queda_detectada'] == true) {
            $categoria = 'Queda';
            $descricao = 'Queda detectada pelo acelerômetro do dispositivo.';
        } elseif (isset($sensores['frequencia_cardiaca']) && ($sensores['frequencia_cardiaca'] < 50 || $sensores['frequencia_cardiaca'] > 120)) {
            $categoria = 'Alerta Cardíaco';
            $descricao = 'Frequência cardíaca anormal (' . $sensores['frequencia_cardiaca'] . ' bpm).';
        }

        if ($categoria) {
            EventoSaude::create([
                'id_usuario'           => $dispositivo->id_usuario,
                'id_dispositivo'       => $dispositivo->id_dispositivo,
                'categoria_evento'     => $categoria,
                'descricao_evento'     => $descricao,
                'frequencia_cardiaca'  => $sensores['frequencia_cardiaca'] ?? null,
                'oxigenacao_spo2'      => $sensores['oxigenacao_spo2'] ?? null,
                'temperatura_corporal' => $sensores['temperatura_corporal'] ?? null,
                'quedas_detectadas'    => $categoria == 'Queda' ? 1 : 0,
                'localizacao_endereco' => isset($gps['latitude'], $gps['longitude']) ? "Lat: {$gps['latitude']}, Lng: {$gps['longitude']}" : null,
                'data_hora_registro'   => $validated['timestamp'] ?? now(),
            ]);
        }

        // Atualizar estado do dispositivo com dados mais recentes
        $updateData = ['status_conexao' => 'Online', 'tempo_ultimo_sinal' => now()->format('H:i:s')];
        if (isset($sensores['nivel_bateria'])) {
            $updateData['nivel_bateria'] = $sensores['nivel_bateria'];
        }
        $dispositivo->update($updateData);

        Log::info('webhook.processed', [
            'codigo_serial' => $dispositivo->codigo_serial,
            'evento_criado' => $categoria !== null
        ]);

        return response()->json(['status' => 'success', 'message' => 'Webhook processado com sucesso.'], 200);
    }
}
