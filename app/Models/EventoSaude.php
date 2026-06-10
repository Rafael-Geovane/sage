<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventoSaude extends Model
{
    protected $table = 'evento_saude';
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    protected $fillable = [
        'frequencia_cardiaca',
        'oxigenacao_spo2',
        'temperatura_corporal',
        'quedas_detectadas',
        'localizacao_endereco',
        'categoria_evento',
        'descricao_evento',
        'id_usuario',
        'id_dispositivo',
        'data_hora_registro',
    ];

    protected function casts(): array
    {
        return [
            'temperatura_corporal' => 'decimal:1',
            'data_hora_registro'   => 'datetime',
        ];
    }

    /**
     * Usuário associado ao evento.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Dispositivo que registrou o evento.
     */
    public function dispositivo(): BelongsTo
    {
        return $this->belongsTo(Dispositivo::class, 'id_dispositivo', 'id_dispositivo');
    }

    /**
     * Retorna a classe CSS da categoria do evento.
     */
    public function getCategoriaCssClassAttribute(): string
    {
        return match ($this->categoria_evento) {
            'Queda'            => 'event-danger',
            'Alerta Cardíaco'  => 'event-warning',
            'Monitoramento'    => 'event-info',
            default            => 'event-success',
        };
    }

    /**
     * Retorna o ícone Lucide da categoria.
     */
    public function getCategoriaIconeAttribute(): string
    {
        return match ($this->categoria_evento) {
            'Queda'            => 'person-standing',
            'Alerta Cardíaco'  => 'heart-pulse',
            'Monitoramento'    => 'activity',
            default            => 'check-circle',
        };
    }
}
