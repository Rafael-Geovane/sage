<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $table = 'ticket';
    protected $primaryKey = 'id_ticket';
    public $timestamps = false;

    protected $fillable = [
        'numero_ticket',
        'assunto',
        'prioridade',
        'status',
        'id_usuario',
        'id_admin_responsavel',
    ];

    protected function casts(): array
    {
        return [
            'criado_em' => 'datetime',
        ];
    }

    /**
     * Usuário que abriu o ticket.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Admin responsável pelo ticket.
     */
    public function adminResponsavel(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin_responsavel', 'id_admin');
    }

    /**
     * Retorna a classe CSS da prioridade.
     */
    public function getPrioridadeCssClassAttribute(): string
    {
        return match ($this->prioridade) {
            'Alta'  => 'high',
            'Média' => 'medium',
            'Baixa' => 'low',
            default => 'low',
        };
    }

    /**
     * Retorna a classe CSS do status.
     */
    public function getStatusCssClassAttribute(): string
    {
        return match ($this->status) {
            'Em Andamento' => 'warning',
            'Respondido'   => 'online',
            'Aguardando'   => 'pending',
            default        => 'offline',
        };
    }
}
