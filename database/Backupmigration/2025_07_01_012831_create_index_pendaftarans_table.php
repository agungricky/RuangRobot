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
        Schema::create('index_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('kategori_id');
            $table->string('link_form', 255)->nullable();
            $table->string('link_group', 255)->nullable();
            $table->date('tanggal_p_awal')->nullable();
            $table->date('tanggal_p_akhir')->nullable();
            $table->enum('status_pendaftaran', ['open', 'closed'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('index_pendaftarans');
    }
};
