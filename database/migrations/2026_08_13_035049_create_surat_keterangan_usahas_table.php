<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_keterangan_usahas', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->text('identitas_pemilik')->nullable();
            $table->string('jenis_komoditi_usaha');
            $table->string('dokumen')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan_usahas');
    }
};