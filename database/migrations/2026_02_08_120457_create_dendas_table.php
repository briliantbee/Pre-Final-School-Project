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
        Schema::create('dendas', function (Blueprint $table) {
          $table->id();
            $table->foreignId('pengembalian_id')->constrained('pengembalians')->onDelete('cascade');
            $table->integer('denda_keterlambatan')->default(0);
            $table->integer('denda_kerusakan')->default(0);
            $table->integer('total_denda')->default(0);
            $table->enum('status', ['belum_dibayar', 'sudah_dibayar'])->default('belum_dibayar');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->foreignId('dikonfirmasi_oleh')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};
