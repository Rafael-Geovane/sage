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
        // Pega o cookie diretamente do $_COOKIE pois o Laravel criptografa cookies via middleware
        // e o frontend gravou o cookie sem criptografia (raw javascript).
        $email = $_COOKIE['sage_email'] ?? null;
        if ($email) {
            $email = urldecode($email); // JavaScript's encodeURIComponent is similar to urlencode
            $usuario = Usuario::with(['dispositivo', 'dispositivos', 'cuidadores', 'ultimoEvento'])
                ->where('email', $email)
                ->first();
        } else {
            // Em produção, seria o usuário logado. Aqui usamos o primeiro para demo.
            $usuario = Usuario::with(['dispositivo', 'dispositivos', 'cuidadores', 'ultimoEvento'])->first();
        }

        if (!$usuario) {
            return view('dashboard', [
                'usuario' => null,
                'ultimoEvento' => null,
                'dispositivo' => null,
                'dispositivos' => collect(),
                'cuidadores' => collect(),
                'eventos' => collect(),
                'quedasHoje' => 0,
            ]);
        }

        $ultimoEvento = $usuario->ultimoEvento;
        $dispositivo  = $usuario->dispositivo;
        $dispositivos = $usuario->dispositivos;
        $cuidadores   = $usuario->cuidadores;

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
            'dispositivo',
            'dispositivos',
            'cuidadores',
            'eventos',
            'quedasHoje',
        ));
    }
}

