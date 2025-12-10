<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categorie_enfants', function (Blueprint $table) {
            $table->id('idCategorie');
            $table->string('categorie', 255);
            $table->timestamps();
        });
        // Données pré-remplies (basées sur l'image)
        DB::table('categorie_enfants')->insert([
            ['categorie' => 'Nourrisson(0-12 mois)'],
            ['categorie' => 'Bambin(1-3 ans)'],
            ['categorie' => 'Maternelle(4-5 ans)'],
            ['categorie' => 'Écolier(6-12 ans)'],
            ['categorie' => 'Adolescent(13-18 ans)'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorie_enfants');
    }
};
