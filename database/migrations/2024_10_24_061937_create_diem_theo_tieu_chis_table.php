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
        Schema::create('nvxs___diem_theo_tieu_chis', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('id_tieu_chi');
            $table->unsignedBigInteger('id_nguoi_cham')->nullable();
            $table->unsignedInteger('id_diem_nv_thang');
            $table->float('diem');
            $table->unsignedTinyInteger('duyet')->nullable()->default(0);

            $table->foreign('id_tieu_chi')
                ->on('nvxs___danh_sach_tieu_chis')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_nguoi_cham')
                ->on('users')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_diem_nv_thang')
                ->on('nvxs___diem_thangs')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nvxs___diem_theo_tieu_chis');
    }
};
