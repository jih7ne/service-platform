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
        Schema::table('offres_services', function (Blueprint $table) {
            $table->enum('statut', ['ACTIVE', 'INACTIVE', 'ARCHIVED', 'VALIDE', 'EN_ATTENTE'])
                  ->default('EN_ATTENTE')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offres_services', function (Blueprint $table) {
            $table->enum('statut', ['ACTIVE', 'INACTIVE', 'ARCHIVED'])
                  ->default('ACTIVE')
                  ->change();
        });
    }
};