<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'email',
        'senha_hash',
        'nivel_acesso',
    ];

    protected $hidden = [
        'senha_hash',
    ];

    /**
     * Usuários gerenciados por este admin.
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'id_admin_responsavel', 'id_admin');
    }

    /**
     * Pedidos sob responsabilidade deste admin.
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'id_admin_responsavel', 'id_admin');
    }

    /**
     * Tickets sob responsabilidade deste admin.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'id_admin_responsavel', 'id_admin');
    }

    /**
     * Retorna as iniciais do nome para exibição em avatares.
     */
    public function getIniciaisAttribute(): string
    {
        $partes = explode(' ', $this->nome);
        $iniciais = strtoupper(substr($partes[0], 0, 1));
        if (count($partes) > 1) {
            $iniciais .= strtoupper(substr(end($partes), 0, 1));
        }
        return $iniciais;
    }
}
