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
        Schema::create('nvxs___danh_muc_thang_nams', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->tinyInteger('thang');
            $table->integer('nam');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nvxs___danh_muc_thang_nams');
    }
};
