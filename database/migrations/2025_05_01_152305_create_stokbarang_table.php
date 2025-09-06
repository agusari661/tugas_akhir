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
        Schema::create('stokbarang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('harga_jual');
            $table->string('harga_beli');
            $table->unsignedInteger('stok');
            $table->date('tgl_masuk')->nullable();
            $table->date('tgl_keluar')->nullable();
            $table->unsignedInteger('jumlah_barang_masuk')->nullable();
            $table->unsignedInteger('jumlah_barang_keluar')->nullable();
            $table->enum('tipe_barang', ['barang_masuk', 'barang_keluar'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stokbarang');
    }
};
