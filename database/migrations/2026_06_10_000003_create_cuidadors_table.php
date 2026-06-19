<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuidador', function (Blueprint $table) {
            $table->id('id_cuidador');
            $table->string('nome', 100);
            $table->string('telefone', 20);
            $table->string('email', 150)->nullable();
            $table->string('parentesco', 50)->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->timestamp('criado_em')->useCurrent();

            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuario')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuidador');
    }
};
