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
        Schema::table('habits', function (Blueprint $table) {
            $table->string('name')->nullable(); // Habit 名
            $table->string('category')->nullable(); // カテゴリ
            $table->date('date')->nullable(); // 日付
        });
    }

    public function down()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn(['name', 'category', 'date']);
        });
    }
};
