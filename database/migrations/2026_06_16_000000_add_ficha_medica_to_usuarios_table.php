<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('tipo_sanguineo', 10)->nullable()->after('nome_plano');
            $table->string('condicoes_medicas', 500)->nullable()->after('tipo_sanguineo');
            $table->string('alergias', 500)->nullable()->after('condicoes_medicas');
            $table->string('medicamentos', 500)->nullable()->after('alergias');
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn([
                'tipo_sanguineo',
                'condicoes_medicas',
                'alergias',
                'medicamentos'
            ]);
        });
    }
};
