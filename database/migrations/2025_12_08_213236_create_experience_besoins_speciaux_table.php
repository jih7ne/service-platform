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
        Schema::create('experience_besoins_speciaux', function (Blueprint $table) {
            $table->id('idExperience');
            $table->string('experience', 255);
        });
        // Données pré-remplies
        DB::table('experience_besoins_speciaux')->insert([
            ['experience' => 'Troubles de l\'anxiété'],
            ['experience' => 'Trouble du Déficit de l\'Attention avec ou sans Hyperactivité (TDAH)'],
            ['experience' => 'Trouble du Spectre de l\'Autisme (TSA)'],
            ['experience' => 'Asthme'],
            ['experience' => 'Trouble Oppositionnel avec Provocation et Troubles du Comportement (TOP/TC)'],
            ['experience' => 'Sourds et malentendants'],
            ['experience' => 'Retard Global de Développement (RGD)'],
            ['experience' => 'Diabète'],
            ['experience' => 'Troubles du langage'],
            ['experience' => 'Épilepsie'],
            ['experience' => 'Allergies alimentaires'],
            ['experience' => 'Hémophilie'],
            ['experience' => 'Troubles Obsessionnels Compulsifs (TOC)'],
            ['experience' => 'Handicap physique'],
            ['experience' => 'Troubles du sommeil'],
            ['experience' => 'Tics'],
            ['experience' => 'Déficience visuelle'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience_besoins_speciaux');
    }
};
