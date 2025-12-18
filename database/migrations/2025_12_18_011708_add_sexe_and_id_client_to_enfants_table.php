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
        Schema::table('enfants', function (Blueprint $table) {
            $table->enum('sexe', ['garcon', 'fille'])->nullable();
            $table->unsignedBigInteger('id_client')->nullable();
            
            // Ajouter la contrainte de clé étrangère
            $table->foreign('id_client')->references('idUser')->on('utilisateurs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enfants', function (Blueprint $table) {
            $table->dropForeign(['id_client']);
            $table->dropColumn(['sexe', 'id_client']);
        });
    }
};
