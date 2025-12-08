<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services_prof', function (Blueprint $table) {
            $table->id('id_service');

            $table->string('titre', 255);
            $table->text('description')->nullable();
            $table->double('prix_par_heure');
            $table->enum('status', ['actif', 'inactif'])->default('actif');
            $table->enum('type_service', ['enligne', 'domicile']);

            $table->timestamp('date_creation')->useCurrent();
            $table->timestamp('date_modification')->useCurrent()->useCurrentOnUpdate();

            // Foreign Keys
            $table->unsignedBigInteger('professeur_id');
            $table->unsignedBigInteger('matiere_id');
            $table->unsignedBigInteger('niveau_id');

            $table->foreign('professeur_id')
                ->references('id_professeur')->on('professeurs')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('matiere_id')
                ->references('id_matiere')->on('matieres')
                ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('niveau_id')
                ->references('id_niveau')->on('niveaux')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {   
        Schema::table('services_prof', function (Blueprint $table) {
            $table->dropForeign(['professeur_id']);
            $table->dropForeign(['matiere_id']);
            $table->dropForeign(['niveau_id']);
        });
        Schema::dropIfExists('services_prof');
    }
};
