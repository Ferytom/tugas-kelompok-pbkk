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
            $table->datetime('waktu');
            $table->string('keterangan')->nullable();
            $table->integer('hargaTotal');
            $table->string('statusTransaksi');
            $table->integer('noMeja')->default(1);
            $table->boolean('isReservasi')->default(False);
            $table->foreignId('promo_id');
            $table->foreignId('user_id');
            $table->foreignId('location_id');
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
