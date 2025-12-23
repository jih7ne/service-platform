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
        // Ajouter les superpouvoirs manquants
        DB::table('superpouvoirs')->insert([
            ['superpouvoir' => 'Langues'],
            ['superpouvoir' => 'Musique'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('superpouvoirs')
            ->whereIn('superpouvoir', ['Langues', 'Musique'])
            ->delete();
    }
};
