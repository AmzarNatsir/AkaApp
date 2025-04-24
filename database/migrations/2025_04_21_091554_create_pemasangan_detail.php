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
        Schema::create('pemasangan_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pelanggan');
            $table->integer('id_pemakaian');
            $table->string('sn_ont', 100);
            $table->string('model_ont', 100);
            $table->string('odp', 100);
            $table->string('tikor_odp', 100);
            $table->string('tikor_pelanggan', 100);
            $table->string('port', 100);
            $table->string('port_ifle', 100);
            $table->string('splitter', 100);
            $table->string('kabel_dc', 100);
            $table->date('tgl_aktivasi')->nullable();
            $table->string('gambar_rumah', 100);
            $table->string('gambar_odp', 100);
            $table->string('gambar_ont_terpasang', 100);
            $table->string('gambar_belakang_ont', 100);
            $table->string('gambar_redaman_odp', 100);
            $table->string('gambar_redaman_rumah_pelanggan', 100);
            $table->string('gambar_lainnya', 100)->nullable();
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasangan_detail');
    }
};
