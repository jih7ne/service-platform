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
        Schema::table('animals', function (Blueprint $table) {
            $table->dropForeign(['idDemande']);

            $table->dropColumn('idDemande');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('animals', function (Blueprint $table) {
            
            $table->unsignedBigInteger('idDemande');

            
            $table->foreign('idDemande')
                ->references('idDemande')
                ->on('demandes_intervention')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }
};
