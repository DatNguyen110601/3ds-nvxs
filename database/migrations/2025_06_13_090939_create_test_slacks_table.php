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
        Schema::create('nvxs___test_slacks', function (Blueprint $table) {
            $table->unsignedInteger('id')->autoIncrement();
            $table->string('ho_ten');
            $table->string('email');
            $table->date('ngay_sinh')->nullable();
            $table->string('so_dien_thoai')->nullable();
            $table->json('json_data')->nullable(); // lưu toàn bộ json Slack gửi về
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nvxs___test_slacks');
    }
};
