<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispositivos', function (Blueprint $table) {
            $table->id('id_dispositivo');
            $table->string('codigo_serial', 50)->unique();
            $table->string('versao_firmware', 20)->nullable();
            $table->integer('nivel_bateria')->nullable();
            $table->string('tipo_conexao', 20)->nullable();
            $table->string('status_conexao', 20)->nullable();
            $table->string('tempo_ultimo_sinal', 30)->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->timestamp('atualizado_em')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispositivos');
    }
};
