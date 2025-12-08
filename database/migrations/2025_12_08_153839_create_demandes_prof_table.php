<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demandes_prof', function (Blueprint $table) {
            $table->id('id_demande_prof'); 

            $table->double('montant_total');

            // Foreign Keys
            $table->unsignedBigInteger('service_prof_id');
            $table->unsignedBigInteger('demande_id');

            $table->foreign('service_prof_id')
                ->references('id_service')->on('services_prof')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('demande_id')
                ->references('idDemande')->on('demandes_intervention')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('demandes_prof', function (Blueprint $table) {
            $table->dropForeign(['service_prof_id']);
            $table->dropForeign(['demande_id']);
        });
        Schema::dropIfExists('demandes_prof');
    }
};
