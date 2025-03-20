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
        Schema::create('user_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('level')->default(1);
            $table->integer('experience_points')->default(0);
            $table->integer('points_to_next_level')->default(100);
            $table->integer('total_points_earned')->default(0);
            $table->json('badges')->nullable(); // 獲得したバッジ
            $table->date('last_login_date')->nullable();
            $table->integer('login_streak')->default(0); // ログイン連続日数
            $table->json('achievements')->nullable(); // 達成した実績
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_levels');
    }
};
