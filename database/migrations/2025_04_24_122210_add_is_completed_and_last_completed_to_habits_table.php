<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->boolean('is_completed')->nullable(); // replace 'column_before' as needed
            $table->timestamp('last_completed')->nullable();
        });
    }
    public function down(): void
    {
        Schema::table('habits', function (Blueprint $table) {
            $table->dropColumn(['is_completed', 'last_completed']);
        });
    }
};