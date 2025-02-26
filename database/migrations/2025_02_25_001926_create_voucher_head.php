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
        Schema::create('voucher_head', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bulan', 2);
            $table->string('tahun', 4);
            $table->integer('agen_id');
            $table->string('status', 10); //default = open, closed
            $table->integer('user_id');
            $table->integer('total_voucher')->nullable();
            $table->double('total_modal')->nullable();
            $table->double('total_laba')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_head');
    }
};
