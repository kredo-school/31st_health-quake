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
    Schema::create('password_resets', function (Blueprint $table) {
        $table->string('email')->index(); // ユーザーのメールアドレス
        $table->string('token');          // 一時トークン
        $table->timestamp('created_at')->nullable(); // トークン生成日時
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_resets', function (Blueprint $table) {
            //
        });
    }
};
