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
        Schema::table('pelanggan', function (Blueprint $table) {
            $table->string('nama_sales', 100)->nullable();
            $table->string('no_telepon_sales', 100)->nullable();
            $table->string('no_rekening_sales', 100)->nullable();
            $table->string('nama_bank', 100)->nullable();
            $table->double('fee_sales')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            //
        });
    }
};
