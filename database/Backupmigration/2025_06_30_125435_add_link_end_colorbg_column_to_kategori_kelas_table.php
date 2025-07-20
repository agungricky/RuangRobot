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
        Schema::table('kategori_kelas', function (Blueprint $table) {
            $table->string('link')->nullable();
            $table->string('color_bg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_kelas', function (Blueprint $table) {
            $table->dropColumn(['link', 'color_bg']);
        });
    }
};
