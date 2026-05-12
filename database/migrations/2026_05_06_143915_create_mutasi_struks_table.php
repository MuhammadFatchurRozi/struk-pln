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
        Schema::create('mutasi_struks', function (Blueprint $table) {
            $table->id();
            $table->string('pelanggan_id'); 
            $table->foreign('pelanggan_id')->references('idpel')->on('pelanggans')->onDelete('cascade');
            $table->string('periode'); 
            $table->integer('biaya_admin');
            $table->integer('tagihan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_struks');
    }
};
