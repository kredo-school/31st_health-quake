<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index()
    {
        // ランキングデータを配列で定義（仮）
        $ranks = [
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 1, 'name' => 'Daniil Medvedev', 'points' => 70],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 2, 'name' => 'Alexander Zverev', 'points' => 66],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 3, 'name' => 'Novak Djokovic', 'points' => 63],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 4, 'name' => 'Rafael Nadal', 'points' => 60],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 5, 'name' => 'Casper Ruud', 'points' => 58],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 6, 'name' => 'Stefanos Tsitsipas', 'points' => 57],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 7, 'name' => 'Carlos Alcaraz', 'points' => 50],
            ['avatar' => 'https://via.placeholder.com/50', 'position' => 8, 'name' => 'Andrey Rublev', 'points' => 45],
        ];

        // ビューにランキングデータを渡す
        return view('ranking', compact('ranks'));
    }
}
