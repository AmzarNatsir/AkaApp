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
        Schema::create('beli_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("header_id");
            $table->foreign('header_id')->references('id')->on('beli_header');
            $table->integer('material_id')->unsigned();
            $table->foreign('material_id')->references('id')->on('materials');
            $table->double('harga');
            $table->integer('jumlah');
            $table->double('sub_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beli_detail');
    }
};
