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
            $table->foreignId('users_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tgl_transaksi');
            $table->decimal('total_pemasukan', 10,2);
            $table->string('kontak_pelanggan', 20)->nullable();
            $table->string('bukti_transaksi')->nullable();
            $table->enum('source', ['online', 'offline'])->nullable();
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
