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
        Schema::table('keuangan', function (Blueprint $table) {
            $table->unsignedInteger('indexkeuangan_id')->nullable()->after('id');
            $table->enum('tipe', ['Pemasukan', 'Pengeluaran'])->after('indexkeuangan_id');
            $table->enum('metode_pembayaran', ['Transfer', 'Cash']);
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropColumn('indexkeuangan_id');
            $table->dropColumn('tipe');
            $table->dropColumn('metode_pembayaran');
            $table->dropColumn('status');
        });
    }
};
