<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('nome', 100);
            $table->string('email', 150)->unique();
            $table->string('senha_hash', 255);
            $table->string('nivel_acesso', 30)->default('operador');
            $table->timestamp('criado_em')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
