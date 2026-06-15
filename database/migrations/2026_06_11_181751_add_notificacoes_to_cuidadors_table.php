<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cuidadors', function (Blueprint $table) {
            $table->boolean('notificar_push')->default(false)->after('id_usuario');
            $table->boolean('notificar_sms')->default(false)->after('notificar_push');
            $table->boolean('notificar_ligacao')->default(false)->after('notificar_sms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuidadors', function (Blueprint $table) {
            $table->dropColumn(['notificar_push', 'notificar_sms', 'notificar_ligacao']);
        });
    }
};
