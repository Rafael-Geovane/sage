<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->string('numero_pedido', 50)->unique();
            $table->string('valor', 30)->nullable();
            $table->string('forma_pagamento', 30)->nullable();
            $table->string('status', 30)->nullable();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_admin_responsavel')->nullable();
            $table->timestamp('criado_em')->useCurrent();

            $table->foreign('id_usuario')
                  ->references('id_usuario')
                  ->on('usuarios')
                  ->onDelete('cascade');

            $table->foreign('id_admin_responsavel')
                  ->references('id_admin')
                  ->on('admins')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
