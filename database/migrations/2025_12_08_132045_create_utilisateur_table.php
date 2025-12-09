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
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('idUser');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telephone');
            $table->enum('statut', ['suspendue', 'actif'])->default('actif');
            $table->enum('role', ['client', 'intervenant']);
            $table->double('note')->default(0);
            $table->string('photo')->nullable();
            $table->unsignedInteger('nbrAvis')->default(0);
            $table->date('dateNaissance');
            $table->integer('idAdmin')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
