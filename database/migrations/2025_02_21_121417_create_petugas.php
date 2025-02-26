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
        Schema::create('petugas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_petugas', 100);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->string('jenkel', 20);
            $table->string('alamat', 100)->nullable();
            $table->string('no_telpon', 50)->nullable();
            $table->string('photo', 100)->nullable();
            $table->string('photo_path', 100)->nullable();
            $table->string("no_identitas", 50)->nullable();
            $table->date("tanggal_bergabung")->nullable();
            $table->string('aktif', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};
