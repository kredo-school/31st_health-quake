<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // role 列を追加（デフォルト値は 'user'）
            $table->string('role')->default('user')->after('password');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // ロールバック時に role 列を削除
            $table->dropColumn('role');
        });
    }
}