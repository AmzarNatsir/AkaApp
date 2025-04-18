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
        Schema::create('kas_keluar', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->date("tgl_transaksi");
            $table->string('no_transaksi', 20);
            $table->string('keterangan');
            $table->double('nominal');
            $table->integer('id_user');
            $table->string('evidence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas_keluar');
    }
};
