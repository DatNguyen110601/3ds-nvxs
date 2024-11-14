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
        Schema::create('nvxs___danh_sach_tieu_chis', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->text('ten_tieu_chi');
            $table->float('diem_toi_da');
            $table->float('diem_toi_thieu')->default(0);
            $table->tinyInteger('he_so');
            $table->boolean('trang_thai')->default(false);

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nvxs___danh_sach_tieu_chis');
    }
};
