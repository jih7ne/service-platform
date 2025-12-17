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
            $table->unsignedBigInteger('id_categorie')->nullable();
            $table->foreign('id_categorie')
                  ->references('idCategorie')
                  ->on('categorie_enfants')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enfants', function (Blueprint $table) {
            $table->dropForeign(['id_categorie']);
            $table->dropColumn('id_categorie');
        });
    }
};
