<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tb_buku', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string(column:'judul_buku');
            $table->string(column:'cover');
            $table->string(column:'dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_buku');
    }
};
