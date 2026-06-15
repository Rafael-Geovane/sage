<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Lista todos os pedidos.
     */
    public function index()
    {
        $pedidos = Pedido::with(['usuario', 'adminResponsavel'])->orderBy('criado_em', 'desc')->get();
        return response()->json($pedidos);
    }

    /**
     * Exibe um pedido específico.
     */
    public function show(int $id)
    {
        $pedido = Pedido::with(['usuario', 'adminResponsavel'])->where('id_pedido', $id)->firstOrFail();
        return response()->json($pedido);
    }

    /**
     * Atualiza um pedido (status, forma de pagamento).
     */
    public function update(Request $request, int $id)
    {
        $pedido = Pedido::where('id_pedido', $id)->firstOrFail();

        $validated = $request->validate([
            'status'          => 'sometimes|string|in:Pend. Pagamento,Enviado,Entregue,Cancelado',
            'forma_pagamento' => 'sometimes|string|in:Pix,Cartão,Boleto',
        ]);

        $pedido->update($validated);
        return response()->json($pedido->load(['usuario', 'adminResponsavel']));
    }
}
