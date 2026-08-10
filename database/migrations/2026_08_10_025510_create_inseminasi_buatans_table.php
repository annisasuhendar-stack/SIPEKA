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
    Schema::create('inseminasi_buatans', function (Blueprint $table) {
        $table->id();
        $table->string('jenis_hewan');
        $table->string('identitas_pemilik');
        $table->text('alamat');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inseminasi_buatans');
    }
};
