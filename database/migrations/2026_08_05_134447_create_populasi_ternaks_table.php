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
    Schema::create('populasi_ternaks', function (Blueprint $table) {
        $table->id();

        $table->foreignId('kecamatan_id')->constrained('kecamatans')->cascadeOnDelete();
        $table->foreignId('desa_id')->constrained('desas')->cascadeOnDelete();

        $table->string('jenis_ternak');
        $table->integer('jumlah');
        $table->year('tahun');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('populasi_ternaks');
    }
};