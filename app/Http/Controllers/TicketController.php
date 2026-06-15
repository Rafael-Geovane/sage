<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Admin;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Lista todos os tickets.
     */
    public function index()
    {
        $tickets = Ticket::with(['usuario', 'adminResponsavel'])->orderBy('criado_em', 'desc')->get();
        return response()->json($tickets);
    }

    /**
     * Exibe um ticket específico.
     */
    public function show(int $id)
    {
        $ticket = Ticket::with(['usuario', 'adminResponsavel'])->where('id_ticket', $id)->firstOrFail();
        return response()->json($ticket);
    }

    /**
     * Cria um novo ticket.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'assunto'              => 'required|string|max:255',
            'prioridade'           => 'required|string|in:Alta,Média,Baixa',
            'id_usuario'           => 'required|exists:usuario,id_usuario',
            'id_admin_responsavel' => 'nullable|exists:admin,id_admin',
        ]);

        // Gerar número de ticket sequencial
        $ultimo = Ticket::orderBy('id_ticket', 'desc')->first();
        $proximoNum = $ultimo ? intval(str_replace('#T-', '', $ultimo->numero_ticket)) + 1 : 900;
        $validated['numero_ticket'] = '#T-' . str_pad($proximoNum, 4, '0', STR_PAD_LEFT);
        $validated['status'] = 'Aguardando';

        $ticket = Ticket::create($validated);
        return response()->json($ticket->load(['usuario', 'adminResponsavel']), 201);
    }

    /**
     * Atualiza um ticket (status, prioridade, admin responsável).
     */
    public function update(Request $request, int $id)
    {
        $ticket = Ticket::where('id_ticket', $id)->firstOrFail();

        $validated = $request->validate([
            'assunto'              => 'sometimes|string|max:255',
            'prioridade'           => 'sometimes|string|in:Alta,Média,Baixa',
            'status'               => 'sometimes|string|in:Aguardando,Em Andamento,Respondido,Fechado',
            'id_admin_responsavel' => 'nullable|exists:admin,id_admin',
        ]);

        $ticket->update($validated);
        return response()->json($ticket->load(['usuario', 'adminResponsavel']));
    }

    /**
     * Exclui um ticket.
     */
    public function destroy(int $id)
    {
        $ticket = Ticket::where('id_ticket', $id)->firstOrFail();
        $ticket->delete();
        return response()->json(['message' => 'Ticket removido com sucesso.']);
    }
}
