<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispositivo extends Model
{
    protected $table = 'dispositivo';
    protected $primaryKey = 'id_dispositivo';
    public $timestamps = false;

    protected $fillable = [
        'codigo_serial',
        'versao_firmware',
        'nivel_bateria',
        'tipo_conexao',
        'status_conexao',
        'tempo_ultimo_sinal',
        'id_usuario',
    ];

    /**
     * Usuário dono deste dispositivo.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Eventos de saúde registrados por este dispositivo.
     */
    public function eventosSaude(): HasMany
    {
        return $this->hasMany(EventoSaude::class, 'id_dispositivo', 'id_dispositivo');
    }

    /**
     * Verifica se o dispositivo está online.
     */
    public function getIsOnlineAttribute(): bool
    {
        return $this->status_conexao === 'Online';
    }

    /**
     * Retorna a cor CSS da bateria baseada no nível.
     */
    public function getBateriaCssColorAttribute(): string
    {
        if ($this->nivel_bateria === null) return 'var(--text-secondary)';
        if ($this->nivel_bateria <= 20) return 'var(--danger)';
        if ($this->nivel_bateria <= 50) return 'var(--warning)';
        return 'var(--success)';
    }
}
