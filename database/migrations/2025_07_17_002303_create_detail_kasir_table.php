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
        Schema::create('detail_kasir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kasir_id')->constrained('kasir');
            $table->foreignId('barang_id')->constrained('barang');
            $table->integer('harga_satuan');
            $table->float('jumlah_beli');
            $table->integer('total_item');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_kasir');
    }
};
