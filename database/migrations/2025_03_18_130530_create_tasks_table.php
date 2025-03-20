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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('scientific_evidence')->nullable(); // 科学的根拠
            $table->integer('default_points')->default(10); // デフォルトの獲得ポイント
            $table->enum('category', ['食事', '睡眠', '運動', 'その他']); // タスクのカテゴリ
            $table->boolean('has_timer')->default(false); // タイマー機能があるか
            $table->integer('timer_duration')->nullable(); // タイマーの持続時間（秒）
            $table->text('benefits')->nullable(); // タスク実行の利点
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
