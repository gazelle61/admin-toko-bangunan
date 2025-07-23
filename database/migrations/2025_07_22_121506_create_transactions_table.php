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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_penerima');
            $table->string('no_telepon');
            $table->text('alamat_pengiriman');
            $table->decimal('total_harga', 15, 2);
            $table->decimal('ongkir', 15, 2)->default(0);
            $table->string('metode_pembayaran');
            $table->enum('status_transactions', ['pending', 'dibayar', 'selesai', 'batal'])->default('pending')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
