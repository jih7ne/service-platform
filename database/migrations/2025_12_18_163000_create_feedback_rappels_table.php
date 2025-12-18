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
        Schema::create('feedback_rappels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idDemande');
            $table->unsignedBigInteger('idClient');
            $table->unsignedBigInteger('idIntervenant');
            $table->enum('type_destinataire', ['client', 'intervenant']);
            $table->integer('rappel_number')->default(1); // 1, 2, 3... (semaine 1, semaine 2, etc.)
            $table->timestamp('date_envoi');
            $table->timestamp('prochain_rappel')->nullable();
            $table->boolean('feedback_fourni')->default(false);
            $table->timestamps();

            $table->foreign('idDemande')->references('idDemande')->on('demande_interventions')->onDelete('cascade');
            $table->foreign('idClient')->references('idUser')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('idIntervenant')->references('IdIntervenant')->on('intervenants')->onDelete('cascade');
            
            $table->index(['idDemande', 'type_destinataire', 'feedback_fourni']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback_rappels');
    }
};
        Schema::dropIfExists('feedback_rappels');
    }
};
