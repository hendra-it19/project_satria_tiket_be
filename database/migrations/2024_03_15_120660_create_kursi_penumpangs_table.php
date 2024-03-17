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
        Schema::create('kursi_penumpangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('transaction_id')->nullable()->references('id')->on('transactions')->cascadeOnDelete();
            $table->foreignId('ticket_id')->references('id')->on('tickets')->cascadeOnDelete();
            $table->string('nomor_kursi', 5)->unique();
            $table->integer('tingkat')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kursi_penumpangs');
    }
};
