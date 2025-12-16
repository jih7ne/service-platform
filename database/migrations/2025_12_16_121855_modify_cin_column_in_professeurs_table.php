<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('professeurs', function (Blueprint $table) {
            $table->string('CIN', 255)->change(); // Augmenter à 255 caractères
        });
    }

    public function down()
    {
        Schema::table('professeurs', function (Blueprint $table) {
            $table->string('CIN', 50)->change(); // Ancienne taille
        });
    }
};