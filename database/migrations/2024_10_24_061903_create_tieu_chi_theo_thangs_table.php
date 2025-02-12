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
        Schema::create('nvxs___tieu_chi_theo_thangs', function (Blueprint $table) {
            $table->unsignedInteger('id_thang_nam');
            $table->unsignedInteger('id_tieu_chi');

            $table->primary(['id_thang_nam','id_tieu_chi']);

            $table->foreign('id_thang_nam')
                ->on('nvxs___danh_muc_thang_nams')
                ->references('id')
                // ->cascadeOnDelete()
                ->onDelete('cascade')
                ->cascadeOnUpdate();

            $table->foreign('id_tieu_chi')
                ->on('nvxs___danh_sach_tieu_chis')
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
        Schema::dropIfExists('nvxs___tieu_chi_theo_thangs');
    }
};
