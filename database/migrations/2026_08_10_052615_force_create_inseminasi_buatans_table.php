<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inseminasi_buatans')) {
            Schema::create('inseminasi_buatans', function (Blueprint $table) {
                $table->id();
                $table->string('jenis_hewan')->nullable();
                $table->string('identitas_pemilik')->nullable();
                $table->text('alamat')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inseminasi_buatans');
    }
};