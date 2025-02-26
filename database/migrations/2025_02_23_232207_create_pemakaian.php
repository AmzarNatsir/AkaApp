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
        Schema::create('pemakaian', function (Blueprint $table) {
            $table->increments('id');
            $table->date("tanggal");
            $table->integer('kategori_id');
            $table->integer('wilayah_id')->nullable();
            $table->integer('petugas_id');
            $table->text('keterangan')->nullable();
            $table->integer('gudang_id');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaian');
    }
};
