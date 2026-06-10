<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'endereco',
        'telefone',
        'email',
        'nome_plano',
        'notificar_push',
        'notificar_sms',
        'notificar_ligacao',
        'id_admin_responsavel',
    ];

    protected function casts(): array
    {
        return [
            'data_nascimento'   => 'date',
            'notificar_push'    => 'boolean',
            'notificar_sms'     => 'boolean',
            'notificar_ligacao' => 'boolean',
        ];
    }

    /**
     * Admin responsável pelo cadastro/gestão.
     */
    public function adminResponsavel(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'id_admin_responsavel', 'id_admin');
    }

    /**
     * Cuidadores (contatos de emergência) vinculados.
     */
    public function cuidadores(): HasMany
    {
        return $this->hasMany(Cuidador::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Dispositivo (colete) vinculado ao usuário.
     */
    public function dispositivo(): HasOne
    {
        return $this->hasOne(Dispositivo::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Pedidos do usuário.
     */
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Tickets de suporte do usuário.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Eventos de saúde registrados.
     */
    public function eventosSaude(): HasMany
    {
        return $this->hasMany(EventoSaude::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Retorna o último evento de saúde.
     */
    public function ultimoEvento(): HasOne
    {
        return $this->hasOne(EventoSaude::class, 'id_usuario', 'id_usuario')
                    ->latestOfMany('data_hora_registro');
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

    /**
     * Retorna a classe CSS do plano.
     */
    public function getPlanoCssClassAttribute(): string
    {
        return match ($this->nome_plano) {
            'Premium' => 'premium',
            'HaaS'    => 'haas',
            default   => 'basic',
        };
    }
}
