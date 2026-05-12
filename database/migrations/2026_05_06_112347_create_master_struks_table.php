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
        Schema::create('master_struks', function (Blueprint $table) {
            $table->id();
            $table->string('id_pelanggan', 20); // Contoh: 513030087368[cite: 1]
            $table->string('nama'); // Contoh: DUL MAJID[cite: 1]
            $table->string('periode'); // Contoh: MAR26[cite: 1]
            $table->string('stand_awal', 10); // Contoh: 00015875[cite: 1]
            $table->string('stand_akhir', 10); // Contoh: 00015965[cite: 1]
            $table->string('tarif_daya'); // Contoh: R1/450 VA[cite: 1]
            $table->integer('biaya_pln'); // Contoh: 39032[cite: 1]
            $table->integer('biaya_admin'); // Contoh: 2500[cite: 1]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_struks');
    }
};
