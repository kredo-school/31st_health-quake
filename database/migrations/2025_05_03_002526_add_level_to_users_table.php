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
        Schema::table('users', function (Blueprint $table) {
            // levelカラムが存在するかチェックする
            if (!Schema::hasColumn('users', 'level')) {
                $table->integer('level')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // down処理は変更しない
        // カラムを削除する場合のみ記述
    }
};
