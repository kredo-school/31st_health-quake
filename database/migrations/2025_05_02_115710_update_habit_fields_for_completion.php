<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHabitFieldsForCompletion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('habits', function (Blueprint $table) {
            if (!Schema::hasColumn('habits', 'is_completed')) {
                $table->boolean('is_completed')->default(false);
            }

            if (!Schema::hasColumn('habits', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }

            if (!Schema::hasColumn('habits', 'last_completed')) {
                $table->timestamp('last_completed')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn(['is_completed', 'completed_at', 'last_completed']);
        });
    }
}
