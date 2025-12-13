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
        Schema::create('animal_demande', function (Blueprint $table) {
            
            $table->unsignedBigInteger('idDemande');
            $table->unsignedBigInteger('idAnimal');

           
            $table->primary(['idDemande', 'idAnimal']);

           
            $table->foreign('idDemande')
                ->references('idDemande')
                ->on('demandes_intervention')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('idAnimal')
                ->references('idAnimale')
                ->on('animals')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_demande');
    }
};
