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
        Schema::create('formations', function (Blueprint $table) {
            $table->id('idFormation');
            $table->string('formation', 255);
            $table->timestamps();
        });
        // Données pré-remplies
        DB::table('formations')->insert([
            ['formation' => 'Diplôme d\'enseignement'],
            ['formation' => 'Diplôme de puériculture'],
            ['formation' => 'Certification premiers secours'],
            ['formation' => 'Certification RCR (Réanimation Cardio-Respiratoire)'],
            ['formation' => 'Certification médicale professionnelle'],
            ['formation' => 'Formation en psychologie de l\'enfant'],
            ['formation' => 'Formation Montessori'],
            ['formation' => 'Certification en nutrition infantile'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
