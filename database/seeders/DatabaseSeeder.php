<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // テストユーザーの作成
        User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);

        // タスクデータの投入
        $this->call([
            TaskSeeder::class,
        ]);
    }
}
