<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    protected $fillable = [
        'numero_pedido',
        'valor',
        'forma_pagamento',
        'status',
        'id_usuario',
        'id_admin_responsavel',
    ];

    /**
     * Usuário que fez o pedido.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Admin responsável pelo pedido.
     */
    public function adminResponsavel(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin_responsavel', 'id_admin');
    }

    /**
     * Retorna a classe CSS do status.
     */
    public function getStatusCssClassAttribute(): string
    {
        return match ($this->status) {
            'Entregue'         => 'online',
            'Enviado'          => 'warning',
            'Pend. Pagamento'  => 'pending',
            default            => 'offline',
        };
    }
}
