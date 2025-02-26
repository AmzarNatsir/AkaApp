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
        Schema::create('voucher_tambahan', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('head_id');
            $table->bigInteger('detail_id');
            $table->date('tanggal');
            $table->integer('stok_tambahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_tambahan');
    }
};
