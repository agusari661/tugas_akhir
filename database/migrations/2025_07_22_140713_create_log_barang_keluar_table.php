<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_barang_keluar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stokbarang_id')->constrained('stokbarang')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Admin yg melakukan
            $table->string('aksi'); // create / update
            $table->text('deskripsi')->nullable(); // Deskripsi perubahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_barang_keluar');
    }
};
