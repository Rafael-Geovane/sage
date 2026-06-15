<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Representa uma leitura de sensores enviada pelo colete IoT.
 * O campo `payload` armazena o JSON cru completo; os demais campos
 * são extraídos para consultas rápidas.
 */
class LeituraSensor extends Model
{
    protected $table = 'leitura_sensor';
    protected $primaryKey = 'id_leitura';
    public $timestamps = false;

    protected $fillable = [
        'id_dispositivo',
        'id_usuario',
        'payload',
        'frequencia_cardiaca',
        'oxigenacao_spo2',
        'temperatura_corporal',
        'acelerometro_x',
        'acelerometro_y',
        'acelerometro_z',
        'giroscopio_x',
        'giroscopio_y',
        'giroscopio_z',
        'latitude',
        'longitude',
        'nivel_bateria',
        'queda_detectada',
        'timestamp_sensor',
        'recebido_em',
    ];

    protected function casts(): array
    {
        return [
            'payload'              => 'array',
            'temperatura_corporal' => 'decimal:1',
            'queda_detectada'      => 'boolean',
            'timestamp_sensor'     => 'datetime',
            'recebido_em'          => 'datetime',
        ];
    }

    /**
     * Dispositivo que enviou a leitura.
     */
    public function dispositivo(): BelongsTo
    {
        return $this->belongsTo(Dispositivo::class, 'id_dispositivo', 'id_dispositivo');
    }

    /**
     * Usuário associado à leitura.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
