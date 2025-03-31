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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('record_date');
            $table->integer('completed_tasks')->default(0); // その日に完了したタスク数
            $table->integer('total_tasks')->default(0); // その日の全タスク数
            $table->integer('points_earned')->default(0); // その日に獲得したポイント
            $table->text('notes')->nullable(); // ユーザーのメモ
            $table->integer('mood_rating')->nullable(); // その日の気分（1-5等）
            $table->json('completed_task_ids')->nullable(); // 完了したタスクのID
            $table->unique(['user_id', 'record_date']); // ユーザーごとに日付は一意
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
