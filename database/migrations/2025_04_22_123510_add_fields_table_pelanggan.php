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
            $table->date('tgl_completed')->nullable();
            $table->date('tgl_finished')->nullable();
            $table->date('tgl_submit_cancel')->nullable();
            $table->text('keterangan_cancel')->nullable();
            $table->date('tgl_canceled')->nullable();
            $table->integer('user_canceled')->nullable();
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
