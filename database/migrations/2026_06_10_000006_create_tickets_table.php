<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket', function (Blueprint $table) {
            $table->id('id_ticket');
            $table->string('numero_ticket', 50)->unique();
            $table->string('assunto', 255)->nullable();
            $table->string('prioridade', 20)->nullable();
            $table->string('status', 30)->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_admin_responsavel')->nullable();
            $table->timestamp('criado_em')->useCurrent();

            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuario')
                  ->onDelete('cascade');

            $table->foreign('id_admin_responsavel')
                  ->references('id_admin')
                  ->on('admin')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket');
    }
};
