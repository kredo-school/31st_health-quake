<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 既存のテーブルに変更を加える
        Schema::table('rewards', function (Blueprint $table) {
            // 例: 新しいカラムを追加
            // $table->string('new_column')->nullable();

            // または既存のカラムを変更
            // $table->renameColumn('old_name', 'new_name');

            // 現在のテーブル構造と新しく作りたい構造を比較して必要な変更を記述
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rewards', function (Blueprint $table) {
            // 変更を元に戻す処理
            // $table->dropColumn('new_column');
        });
    }
}

