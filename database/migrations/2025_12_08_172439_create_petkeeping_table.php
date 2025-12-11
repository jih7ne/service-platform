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
        Schema::create('petkeeping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idPetKeeping');
            $table->unsignedBigInteger('idPetKeeper');
            $table->enum('categorie_petkeeping', ['A_DOMICILE','DEPLACEMENT','PENSION','PROMENADE','GARDERIE','DRESSAGE']);
            $table->boolean('accepts_aggressive_pets')->default(0);
            $table->enum('payment_criteria', ['PER_HOUR','PER_DAY','PER_NIGHT','PER_VISIT','PER_WALK','PER_PET','PER_SPECIES','PER_WEIGHT','PER_SERVICE','PER_DISTANCE']);
            $table->double('base_price');
            $table->double('note')->default(0);
            $table->boolean('accepts_untrained_pets')->default(0);
            $table->boolean('vaccination_required')->default(0);
            $table->string('pet_type', 255);
            $table->enum('statut', ['ACTIVE','INACTIVE','ARCHIVED']);

            $table->timestamps();

            $table->foreign('idPetKeeping')
                  ->references('idService')
                  ->on('services')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('idPetKeeper')
                  ->references('idIntervenant')
                  ->on('intervenants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petkeeping');
    }
};
