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
        Schema::create('nvxs___diem_thangs', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->unsignedInteger('id_thang_nam');
            $table->unsignedBigInteger('id_nhan_vien');
            $table->float('tong_diem');

            $table->foreign('id_thang_nam')
                ->on('nvxs___danh_muc_thang_nams')
                ->references('id')
                // ->cascadeOnDelete()
                ->onDelete('cascade')

                ->cascadeOnUpdate();

            $table->foreign('id_nhan_vien')
                ->on('users')
                ->references('id')
                // ->cascadeOnDelete()
                ->onDelete('cascade')

                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nvxs___diem_thangs');
    }
};
