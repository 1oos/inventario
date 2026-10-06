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
        if (!Schema::hasColumn('articulos', 'codigo_barras')) {
            Schema::table('articulos', function (Blueprint $table) {
                $table->string('codigo_barras')->nullable()->unique()->after('modelo');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('articulos', 'codigo_barras')) {
            Schema::table('articulos', function (Blueprint $table) {
                $table->dropColumn('codigo_barras');
            });
        }
    }
};
