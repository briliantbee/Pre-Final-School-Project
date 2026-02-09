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
        Schema::create('peminjamans', function (Blueprint $table) {
           $table->id();
            $table->string('kode_peminjaman')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('alat_id')->constrained('alats')->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_berakhir_peminjaman');
            $table->enum('status', [
                'menunggu_konfirmasi',
                'disetujui',
                'ditolak',
                'dipinjam',
                'dikembalikan',
                'melewati_jadwal'
            ])->default('menunggu_konfirmasi');
            $table->text('keperluan')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_disetujui')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
