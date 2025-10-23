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
        Schema::create('infaqs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_donatur', 150);
            $table->decimal('nominal', 15, 2);
            $table->enum('metode', ['online', 'offline'])->default('offline');
            $table->enum('status', ['pending', 'sukses', 'gagal', 'dibatalkan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->string('bukti_transfer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infaqs');
    }
};
