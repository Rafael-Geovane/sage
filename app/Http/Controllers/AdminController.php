<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Dispositivo;
use App\Models\Pedido;
use App\Models\Ticket;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    /**
     * Cria uma nova conta de administrador.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:admin,email',
            'senha' => 'required|string|min:6',
        ]);

        $admin = Admin::create([
            'nome' => $validated['nome'],
            'email' => $validated['email'],
            'senha_hash' => Hash::make($validated['senha']),
            'nivel_acesso' => 'admin',
        ]);

        return response()->json([
            'message' => 'Admin criado com sucesso',
            'admin' => $admin
        ], 201);
    }
}
