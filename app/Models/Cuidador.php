<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuidador extends Model
{
    protected $table = 'cuidador';
    protected $primaryKey = 'id_cuidador';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'telefone',
        'email',
        'parentesco',
        'id_usuario',
    ];

    /**
     * Usuário ao qual este cuidador está vinculado.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Retorna as iniciais do nome para avatares.
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
