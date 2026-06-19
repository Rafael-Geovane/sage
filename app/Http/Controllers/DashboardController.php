<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\EventoSaude;

class DashboardController extends Controller
{
    /**
     * Dashboard do cuidador — exibe dados vitais do primeiro usuário (demo).
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $email = $request->cookie('sage_email');
        if ($email) {
            $email = urldecode($email);
            $usuario = Usuario::with(['dispositivo', 'dispositivos', 'cuidadores', 'ultimoEvento', 'ultimaLeitura'])
                ->where('email', $email)
                ->first();
        } else {
            return redirect('/');
        }

        if (!$usuario) {
            return view('dashboard', [
                'usuario' => null,
                'ultimoEvento' => null,
                'ultimaLeitura' => null,
                'dispositivo' => null,
                'dispositivos' => collect(),
                'cuidadores' => collect(),
                'eventos' => collect(),
                'quedasHoje' => 0,
            ]);
        }

        $ultimoEvento = $usuario->ultimoEvento;
        $ultimaLeitura = $usuario->ultimaLeitura;
        $dispositivo  = $usuario->dispositivo;
        $dispositivos = $usuario->dispositivos;
        $cuidadores   = $usuario->cuidadores;

        // Puxar dados ao vivo do Webhook.site
        try {
            $response = \Illuminate\Support\Facades\Http::get('https://webhook.site/token/4772b7fa-2469-4c0c-b496-dfc8adb12b95/requests');
            if ($response->successful()) {
                $requests = $response->json('data');
                // Pegar o último POST (que contém o JSON)
                $latestPost = collect($requests)->where('method', 'POST')->sortByDesc('created_at')->first();
                if ($latestPost && !empty($latestPost['content'])) {
                    $content = json_decode($latestPost['content'], true);
                    if (isset($content['sensores'])) {
                        $sensores = $content['sensores'];
                        
                        // Substitui a leitura do banco pelos dados em tempo real da API do webhook
                        $ultimaLeitura = (object) [
                            'recebido_em' => \Carbon\Carbon::parse($latestPost['created_at']),
                            'frequencia_cardiaca' => $sensores['frequencia_cardiaca'] ?? null,
                            'oxigenacao_spo2' => $sensores['oxigenacao_spo2'] ?? null,
                            'temperatura_corporal' => $sensores['temperatura_corporal'] ?? null,
                            'latitude' => $sensores['gps']['latitude'] ?? null,
                            'longitude' => $sensores['gps']['longitude'] ?? null,
                        ];

                        // Atualiza dinamicamente o status do dispositivo no dashboard
                        if ($dispositivo) {
                            $dispositivo->nivel_bateria = $sensores['nivel_bateria'] ?? $dispositivo->nivel_bateria;
                            $dispositivo->status_conexao = 'Online';
                            $dispositivo->is_online = true;
                            $dispositivo->tempo_ultimo_sinal = 'Ao vivo (Webhook.site)';
                            $dispositivo->bateria_css_color = $dispositivo->nivel_bateria > 20 ? 'var(--success)' : 'var(--danger)';
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Se falhar a requisição, mantém os dados do banco
        }

        session(['cuidadores_ids' => $cuidadores->pluck('id_cuidador')->toArray()]);

        // Eventos de saúde para o log (mais recentes primeiro)
        $eventos = EventoSaude::where('id_usuario', $usuario->id_usuario)
                              ->orderBy('data_hora_registro', 'desc')
                              ->limit(20)
                              ->get();

        // Contagem de quedas hoje
        $quedasHoje = EventoSaude::where('id_usuario', $usuario->id_usuario)
                                 ->where('categoria_evento', 'Queda')
                                 ->whereDate('data_hora_registro', today())
                                 ->sum('quedas_detectadas');

        return view('dashboard', compact(
            'usuario',
            'ultimoEvento',
            'ultimaLeitura',
            'dispositivo',
            'dispositivos',
            'cuidadores',
            'eventos',
            'quedasHoje',
        ));
    }
}

