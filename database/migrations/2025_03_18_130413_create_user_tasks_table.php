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
        Schema::create('user_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('routine_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('order')->default(0); // ルーティン内の順序
            $table->integer('points')->nullable(); // カスタマイズされたポイント
            $table->time('scheduled_time')->nullable(); // 実行予定時間
            $table->boolean('is_completed')->default(false); // 本日の完了状態
            $table->dateTime('last_completed_at')->nullable(); // 最後に完了した日時
            $table->integer('consecutive_days')->default(0); // 連続達成日数
            $table->integer('completion_count')->default(0); // 累計達成回数
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tasks');
    }
};
