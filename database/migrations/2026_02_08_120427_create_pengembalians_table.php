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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
            $table->date('tanggal_pengembalian');
            $table->integer('jumlah_dikembalikan')->default(1);
            $table->enum('kondisi_alat', ['baik', 'rusak', 'hilang', 'tidak_lengkap'])->default('baik');
            $table->foreignId('diterima_oleh')->constrained('users');
            $table->boolean('terlambat')->default(false);
            $table->integer('hari_terlambat')->default(0);
            $table->text('catatan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
