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
        Schema::create('superpouvoirs', function (Blueprint $table) {
            $table->id('idSuperpouvoir');
            $table->string('superpouvoir', 255);
        });
        // Données pré-remplies
        DB::table('superpouvoirs')->insert([
            ['superpouvoir' => 'Dessin'],
            ['superpouvoir' => 'Tâches ménagères'],
            ['superpouvoir' => 'Cuisine'],
            ['superpouvoir' => 'À l\'aise avec les animaux domestiques'],
            ['superpouvoir' => 'Aide aux devoirs'],
            ['superpouvoir' => 'Travaux manuels'],
            ['superpouvoir' => 'Jeux'],
            ['superpouvoir' => 'Faire la lecture'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('superpouvoirs');
    }
};
