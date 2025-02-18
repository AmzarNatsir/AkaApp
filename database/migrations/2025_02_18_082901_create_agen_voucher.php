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
        Schema::create('agen_voucher', function (Blueprint $table) {
            $table->id();
            $table->string('nama_agen', 100);
            $table->string("alamat", 100)->nullable();
            $table->string('no_telepon', 50)->nullable();
            $table->string('kontak_person', 100)->nullable();
            $table->string('aktif', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agen_voucher');
    }
};
