<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class LevelController extends Controller
{
    /**
     * レベルアップ画面を表示
     */
    public function showLevelUp()
    {
        // セッションからレベル情報を取得
        $currentLevel = session('current_level');
        $nextLevel = session('next_level');

        // セッションに情報がない場合はユーザーから取得
        if ($currentLevel === null || $nextLevel === null) {
            $user = Auth::user();

            try {
                // DBからレベル情報を取得
                $currentLevel = ($user->level ?? 1) - 1; // 現在はすでにレベルアップ後なので-1
                if ($currentLevel < 1) $currentLevel = 1;
                $nextLevel = $user->level ?? 2;
            } catch (\Exception $e) {
                // DBにlevelフィールドがない場合
                $currentLevel = session('user_level', 1);
                // すでにレベルアップ済みなので、現在のレベルは-1
                if ($currentLevel > 1) $currentLevel--;
                $nextLevel = session('user_level', 1);
            }
        }

        // 今日の日付をビューに渡す
        $today = Carbon::now()->format('Y-m-d');

        // ビューファイル名はlevel-up.blade.phpを使用
        return view('level-up', [
            'currentLevel' => $currentLevel,
            'nextLevel' => $nextLevel,
            'today' => $today
        ]);
    }
}
