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
        Schema::create('pembayaran_pelanggan', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tgl_bayar');
            $table->integer('id_pelanggan');
            $table->integer('id_pemasangan')->nullable();
            $table->date('tgl_jtp')->nullable();
            $table->double('nominal');
            $table->integer('id_user');
            $table->string('status', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pelanggan');
    }
};
