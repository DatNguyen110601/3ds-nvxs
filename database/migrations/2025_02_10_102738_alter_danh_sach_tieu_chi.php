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
        Schema::table('nvxs___danh_sach_tieu_chis', function (Blueprint $table) {
            //
            $table->text('mo_ta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nvxs___danh_sach_tieu_chis', function (Blueprint $table) {
            //
            $table->dropColumn('mo_ta');
        });
    }
};
