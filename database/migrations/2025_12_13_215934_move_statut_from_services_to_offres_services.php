<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Étape 1 : Ajouter statut à offres_services
        Schema::table('offres_services', function (Blueprint $table) {
            $table->enum('statut', ['ACTIVE', 'INACTIVE', 'ARCHIVED'])
                  ->default('ACTIVE')
                  ->after('idService'); // Place la colonne après idService
        });

        // Étape 2 : Supprimer statut de services
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }

    public function down(): void
    {
        // Pour rollback : restaurer l'état original
        Schema::table('services', function (Blueprint $table) {
            $table->enum('statut', ['ACTIVE', 'INACTIVE', 'ARCHIVED'])
                  ->default('ACTIVE')
                  ->after('description');
        });

        Schema::table('offres_services', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};