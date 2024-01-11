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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->enum('hari_keberangkatan', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu']);
            $table->time('jam_keberangkatan');
            $table->enum('tujuan', ['lasalimu-wanci', 'wanci-lasalimu']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
