<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leitura_sensor', function (Blueprint $table) {
            $table->id('id_leitura');

            // Relacionamentos
            $table->integer('id_dispositivo');
            $table->integer('id_usuario')->nullable();

            // JSON cru do colete (armazena o payload completo para referência)
            $table->json('payload')->nullable();

            // Campos extraídos para consulta rápida
            $table->integer('frequencia_cardiaca')->nullable();
            $table->integer('oxigenacao_spo2')->nullable();
            $table->decimal('temperatura_corporal', 4, 1)->nullable();

            // Acelerômetro (m/s²)
            $table->decimal('acelerometro_x', 8, 3)->nullable();
            $table->decimal('acelerometro_y', 8, 3)->nullable();
            $table->decimal('acelerometro_z', 8, 3)->nullable();

            // Giroscópio (°/s)
            $table->decimal('giroscopio_x', 8, 3)->nullable();
            $table->decimal('giroscopio_y', 8, 3)->nullable();
            $table->decimal('giroscopio_z', 8, 3)->nullable();

            // GPS
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Estado do dispositivo
            $table->integer('nivel_bateria')->nullable();
            $table->boolean('queda_detectada')->default(false);

            // Timestamps
            $table->dateTime('timestamp_sensor')->nullable();   // hora do sensor
            $table->timestamp('recebido_em')->useCurrent();     // hora do servidor

            // Foreign keys
            $table->foreign('id_dispositivo')
                  ->references('id_dispositivo')
                  ->on('dispositivo')
                  ->onDelete('cascade');

            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuario')
                  ->onDelete('set null');

            // Index para consultas de leitura recente
            $table->index(['id_dispositivo', 'recebido_em']);
            $table->index(['id_usuario', 'recebido_em']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leitura_sensor');
    }
};
