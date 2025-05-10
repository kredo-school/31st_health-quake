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
        // カラムが存在するかチェックしてから追加
        Schema::table('habits', function (Blueprint $table) {
            if (!Schema::hasColumn('habits', 'is_completed')) {
                $table->boolean('is_completed')->default(false);
            }
            // 他のカラムも同様に
            // if (!Schema::hasColumn('habits', '他のカラム名')) {
            //     $table->カラム型('他のカラム名')->デフォルト値();
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ここではカラムを削除する場合の処理を記述
        // 注意：このマイグレーションで追加したカラムのみを削除
        // Schema::table('habits', function (Blueprint $table) {
        //     $table->dropColumn('is_completed');
        // });
    }
};
