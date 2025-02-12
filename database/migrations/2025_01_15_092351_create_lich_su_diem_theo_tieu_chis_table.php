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
        Schema::create('nvxs___lich_su_diem_theo_tieu_chis', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('id_tieu_chi');
            $table->unsignedInteger('id_diem_nv_thang');
            $table->float('diem');
            $table->text('ly_do')->nullable();

            $table->foreign('id_tieu_chi')
                ->on('nvxs___danh_sach_tieu_chis')
                ->references('id')
                ->cascadeOnDelete()
                // ->onDelete('cascade')
                ->cascadeOnUpdate();

            $table->foreign('id_diem_nv_thang')
                ->on('nvxs___lich_su_diem_thangs')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nvxs___lich_su_diem_theo_tieu_chis');
    }
};
