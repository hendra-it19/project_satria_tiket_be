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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ship_id')->references('id')->on('ships');
            $table->integer('sisa_stok');
            $table->integer('stok');
            $table->integer('harga');
            $table->enum('tujuan', ['lasalimu-wanci', 'wanci-lasalimu']);
            $table->dateTime('keberangkatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
