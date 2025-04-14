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
            $table->integer('duration')->default(300); // デフォルト値は300秒（5分）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
};