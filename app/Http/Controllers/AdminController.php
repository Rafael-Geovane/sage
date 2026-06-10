<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Dispositivo;
use App\Models\Pedido;
use App\Models\Ticket;

class AdminController extends Controller
{
    /**
     * Visão geral do painel administrativo.
     */
    public function index()
    {
        $totalUsuarios      = Usuario::count();
        $dispositivosOnline = Dispositivo::where('status_conexao', 'Online')->count();
        $totalPedidos       = Pedido::count();
        $ticketsAbertos     = Ticket::whereIn('status', ['Em Andamento', 'Aguardando'])->count();

        // Dados para a seção de usuários
        $usuarios = Usuario::with('dispositivo')->get();

        // Dispositivos (frota IoT)
        $dispositivos = Dispositivo::with('usuario')->get();
        $dispositivosOffline   = Dispositivo::where('status_conexao', 'Offline')->count();
        $dispositivosBatCrit   = Dispositivo::where('nivel_bateria', '<=', 20)
                                            ->where('nivel_bateria', '>', 0)->count();

        // Pedidos
        $pedidos = Pedido::with('usuario')->latest('criado_em')->get();

        // Tickets
        $tickets        = Ticket::with('usuario')->latest('criado_em')->get();
        $ticketsAlta    = Ticket::where('prioridade', 'Alta')
                                ->whereIn('status', ['Em Andamento', 'Aguardando'])->count();

        return view('admin', compact(
            'totalUsuarios',
            'dispositivosOnline',
            'totalPedidos',
            'ticketsAbertos',
            'usuarios',
            'dispositivos',
            'dispositivosOffline',
            'dispositivosBatCrit',
            'pedidos',
            'tickets',
            'ticketsAlta',
        ));
    }
}
