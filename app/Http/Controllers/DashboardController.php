<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\EventoSaude;

class DashboardController extends Controller
{
    /**
     * Dashboard do cuidador — exibe dados vitais do primeiro usuário (demo).
     */
    public function index()
    {
        // Em produção, seria o usuário logado. Aqui usamos o primeiro para demo.
        $usuario = Usuario::with(['dispositivo', 'cuidadores', 'ultimoEvento'])->first();

        if (!$usuario) {
            return view('dashboard');
        }

        $ultimoEvento = $usuario->ultimoEvento;
        $dispositivo  = $usuario->dispositivo;
        $cuidadores   = $usuario->cuidadores;

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
            'cuidadores',
            'eventos',
            'quedasHoje',
        ));
    }
}
