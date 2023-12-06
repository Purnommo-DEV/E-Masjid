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
        Schema::create('infaq', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->foreignId('masjid_id')->constrained('masjid');
            $table->foreignId('kategori_id')->constrained('kategori');
            $table->string('tanggal');
            $table->string('jenis');
            $table->string('jumlah')->nullable();
            $table->string('satuan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infaq');
    }
};
