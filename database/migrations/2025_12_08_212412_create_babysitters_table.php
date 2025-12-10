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
        Schema::create('babysitters', function (Blueprint $table) {
            $table->unsignedBigInteger('idBabysitter')->primary();
            $table->double('prixHeure');
            $table->integer('expAnnee')->nullable();
            $table->string('langues', 255)->nullable();
            $table->string('procedeJuridique', 255)->nullable();
            $table->string('coprocultureSelles', 255)->nullable();
            $table->string('certifAptitudeMentale', 255)->nullable();
            $table->string('radiographieThorax', 255)->nullable();
            $table->text('maladies')->nullable();
            $table->boolean('estFumeur')->default(false);
            $table->boolean('mobilite')->default(false);
            $table->boolean('possedeEnfant')->default(false);
            $table->boolean('permisConduite')->default(false);
            $table->text('description')->nullable();
            $table->string('niveauEtudes', 255)->nullable();
            
            // NOUVELLE COLONNE - remplace la table preference_domicils
            $table->enum('preference_domicil', [
                'domicil_babysitter',
                'domicil_client',
                'les_deux'
            ])->nullable();

            // Foreign key
            $table->foreign('idBabysitter')
                  ->references('idIntervenant')
                  ->on('intervenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('babysitters', function (Blueprint $table) {
            $table->dropForeign(['idBabysitter']);
        });
        Schema::dropIfExists('babysitters');
    }
};
