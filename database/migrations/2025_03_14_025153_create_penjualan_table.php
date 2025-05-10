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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
            $table->date('tgl_transaksi');
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->decimal('total_pemasukan', 10,2);
            $table->integer('jumlah_terjual');
            $table->string('kontak_pelanggan', 20);
            $table->string('bukti_transaksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualan');
    }
};
