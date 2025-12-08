<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id('id_professeur'); 

            $table->string('CIN', 20)->nullable();
            $table->string('surnom', 100)->nullable();
            $table->text('biographie')->nullable();
            $table->string('diplome', 255)->nullable();
            $table->string('niveau_etudes', 200)->nullable();

            $table->unsignedBigInteger('intervenant_id');

            $table->foreign('intervenant_id')
                ->references('idIntervenant')
                ->on('intervenants')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('professeurs', function (Blueprint $table) {
            $table->dropForeign(['intervenant_id']);
        });
        Schema::dropIfExists('professeurs');
    }
};
