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
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('material', 200);
            $table->double('harga_beli')->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('satuan_id')->nullable();
            $table->integer('merek_id')->nullable();
            $table->string('gambar', 100)->nullable();
            $table->string('path_gambar', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
