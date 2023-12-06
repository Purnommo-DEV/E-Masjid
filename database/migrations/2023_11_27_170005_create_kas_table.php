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
        Schema::create('kas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('masjid_id')->constrained('masjid');
            $table->dateTime('tanggal_transaksi');
            $table->text('keterangan');
            $table->enum('jenis_transaksi', ['masuk', 'keluar']);
            $table->bigInteger('jumlah');
            $table->text('path')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};
