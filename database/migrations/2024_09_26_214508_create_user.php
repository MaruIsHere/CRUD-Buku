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
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string(column:'username_user');
            $table->string(column:'password_user');
            $table->string(column:'nama_user');
            $table->string(column:'alamat_user');
            $table->string(column:'nomor_telp');
            $table->string(column:'jabatan');
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
