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
        Schema::table('petkeepers', function (Blueprint $table) {
            $table->unsignedInteger('years_of_experience')
                  ->default(0)
                  ->after('specialite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petkeepers', function (Blueprint $table) {
            $table->dropColumn('years_of_experience');
        });
    }
};
