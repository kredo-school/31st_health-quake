<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     
     public function run()
     {
         DB::table('users')->insert([
             'username' => 'testuser',
             'password' => Hash::make('password123'), // パスワードはハッシュ化
         ]);
     }
    
}
