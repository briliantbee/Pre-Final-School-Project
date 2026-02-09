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
        Schema::create('alats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_alat');
            $table->string('kode_alat')->unique();
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(0);
            $table->integer('stok_tersedia')->default(0);
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->enum('status', ['tersedia', 'tidak_tersedia'])->default('tersedia');
            $table->string('foto')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};
