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
        Schema::create('infaq_rincian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('infaq_id')->constrained('infaq');
            $table->foreignId('sub_kategori_id')->constrained('sub_kategori');
            $table->foreignId('pecahan_id')->constrained('pecahan_master');
            $table->string('jumlah');
            $table->string('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infaq_rincian');
    }
};
