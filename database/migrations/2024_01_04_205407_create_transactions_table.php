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
            $table->string('transaction_id');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('ticket_id')->references('id')->on('tickets');
            $table->integer('jumlah');
            $table->float('harga');
            $table->float('total_harga');
            $table->enum('status', ['pending', 'proses', 'selesai'])->default('pending');
            $table->enum('metode_pembayaran', ['gopay', 'qris'])->nullable();
            $table->string('qr_url')->nullable();
            $table->dateTime('expired')->nullable();
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
