<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('disponibilites', function (Blueprint $table) {
            $table->string('jourSemaine', 20)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('disponibilites', function (Blueprint $table) {
            $table->string('jourSemaine', 20)->nullable(false)->change();
        });
    }
};