<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nome', 100);
            $table->string('cpf', 14)->nullable()->unique();
            $table->date('data_nascimento')->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('email', 150)->nullable()->unique();
            $table->string('nome_plano', 30)->nullable();
            $table->boolean('notificar_push')->default(false);
            $table->boolean('notificar_sms')->default(false);
            $table->boolean('notificar_ligacao')->default(false);
            $table->unsignedBigInteger('id_admin_responsavel')->nullable();
            $table->timestamp('criado_em')->useCurrent();

            $table->foreign('id_admin_responsavel')
                  ->references('id_admin')
                  ->on('admins')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
