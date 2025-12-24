<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration {
    public function up(): void
    {
        // 1️⃣ Convert DOUBLE → STRING (temporary)
        Schema::table('animals', function (Blueprint $table) {
            $table->string('taille', 10)->change();
        });

        // 2️⃣ Convert numeric values → enum labels
        DB::statement("
            UPDATE animals
            SET taille = CASE
                WHEN CAST(taille AS DECIMAL(10,2)) < 30 THEN 'Petit'
                WHEN CAST(taille AS DECIMAL(10,2)) BETWEEN 30 AND 60 THEN 'Moyen'
                ELSE 'Grand'
            END
        ");

        // 3️⃣ Convert STRING → ENUM
        Schema::table('animals', function (Blueprint $table) {
            $table->enum('taille', ['Petit', 'Moyen', 'Grand'])->change();
        });
    }

    public function down(): void
    {
        // Rollback ENUM → DOUBLE
        Schema::table('animals', function (Blueprint $table) {
            $table->double('taille')->change();
        });
    }
};
