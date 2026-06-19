<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evento_saude', function (Blueprint $table) {
            $table->id('id_evento');
            $table->integer('frequencia_cardiaca')->nullable();
            $table->integer('oxigenacao_spo2')->nullable();
            $table->decimal('temperatura_corporal', 4, 1)->nullable();
            $table->integer('quedas_detectadas')->nullable();
            $table->string('localizacao_endereco', 255)->nullable();
            $table->string('categoria_evento', 50)->nullable();
            $table->text('descricao_evento')->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_dispositivo')->nullable();
            $table->dateTime('data_hora_registro')->useCurrent();

            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuario')
                  ->onDelete('cascade');

            $table->foreign('id_dispositivo')
                  ->references('id_dispositivo')
                  ->on('dispositivo')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evento_saude');
    }
};
