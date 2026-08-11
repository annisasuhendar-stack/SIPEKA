<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skkhs', function (Blueprint $table) {
            $table->id();

            $table->string('nomor_surat')->nullable();

            $table->string('nama_pemilik');
            $table->text('identitas_pemilik')->nullable();

            $table->string('jenis_hewan');
            $table->string('tujuan_pengiriman')->nullable();

            $table->string('dokumen')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skkhs');
    }
};