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
        Schema::create('voucher_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('head_id');
            $table->integer('voucher_id');
            $table->string('nama_voucher', 50);
            $table->double('harga_modal');
            $table->double('harga_jual');
            $table->integer('stok_awal');
            $table->integer('stok_terjual')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_detail');
    }
};
