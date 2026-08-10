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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id');
            $table->foreign('author_id')->references('id')->on('profile')
                ->onDelete('cascade');

            $table->integer('kelas_id');
            $table->foreign('kelas_id')
                ->references('id')
                ->on('kelas')
                ->cascadeOnDelete();

            $table->string('pemahaman');
            $table->string('keterampilan');
            $table->string('keamanan');
            $table->string('antusiasme');
            $table->string('percaya_diri');
            $table->integer('idreport');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
