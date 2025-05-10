<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Habit; // 追加：習慣の完了数をカウントするため
use App\Models\CompletedHabit; // 追加：CompletedHabitモデルも使用
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LevelController extends Controller
{
    /**
     * レベルアップ画面を表示
     */
    public function showLevelUp()
    {
        Log::debug('Level up screen called');

        // 現在のユーザーを取得
        $user = Auth::user();

        // 完了した習慣の総数を取得
        $completedHabitsCount = Habit::where('user_id', $user->id)
            ->where('is_completed', 1)
            ->count();

        // CompletedHabitテーブルからも完了した習慣を取得（追加）
        $completedHabitsFromCompletedTable = CompletedHabit::where('user_id', $user->id)
            ->count();

        // 両方のソースからの完了した習慣の総数を計算
        $totalCompletedHabits = $completedHabitsCount + $completedHabitsFromCompletedTable;

        Log::debug("User has completed {$totalCompletedHabits} habits total ({$completedHabitsCount} from Habits, {$completedHabitsFromCompletedTable} from CompletedHabits)");

        // レベルを計算（5つの習慣ごとに1レベルアップ）
        $calculatedLevel = (int)($totalCompletedHabits / 5) + 1;

        // ユーザーのDBモデルにレベルが保存されているか確認
        $hasLevelField = $this->hasLevelField();

        if ($hasLevelField) {
            // DBにlevelフィールドがある場合は保存/更新
            try {
                // 新しいレベルがDBに保存されているレベルより高ければ更新
                if ($calculatedLevel > ($user->level ?? 1)) {
                    $user->level = $calculatedLevel;
                    $user->save();
                    Log::debug("Updated user level in DB to {$calculatedLevel}");
                } else {
                    // 計算されたレベルがDBのレベルより低い場合、DBの値を使用
                    $calculatedLevel = $user->level ?? 1;
                    Log::debug("Using existing DB level: {$calculatedLevel}");
                }
            } catch (\Exception $e) {
                Log::error("Failed to update user level in DB: " . $e->getMessage());
            }
        } else {
            // DBにlevelフィールドがない場合はセッションに保存
            $sessionLevel = session('user_level', 1);
            if ($calculatedLevel > $sessionLevel) {
                session(['user_level' => $calculatedLevel]);
                Log::debug("Updated user level in session to {$calculatedLevel}");
            } else {
                $calculatedLevel = $sessionLevel;
                Log::debug("Using existing session level: {$calculatedLevel}");
            }
        }

        // セッションからレベルアップ前の前回のレベルを取得
        $previousLevel = session('current_level', $calculatedLevel - 1);
        if ($previousLevel < 1) $previousLevel = 1;

        // 現在のレベルと次のレベルを設定
        $currentLevel = $previousLevel;
        $nextLevel = $calculatedLevel;

        // もしレベルアップがなければ（前回と同じレベル）
        if ($currentLevel >= $nextLevel) {
            $nextLevel = $currentLevel + 1;
        }

        Log::debug("Level values set - currentLevel: {$currentLevel}, nextLevel: {$nextLevel}");

        // 今日の日付をビューに渡す
        $today = Carbon::now()->format('Y-m-d');

        // 次の報酬レベルを計算 - 修正: 現在ではなく次のレベルを基準にする
        $nextRewardLevel = $this->calculateNextRewardLevel($nextLevel);
        Log::debug("Next reward level: {$nextRewardLevel}");

        // レベルが3の倍数かチェック
        $isRewardLevel = $this->isRewardLevel($nextLevel);
        Log::debug("Is reward level: " . ($isRewardLevel ? 'Yes' : 'No'));

        // 重要：カレンダーに遷移するURLに完了したhabitの情報を付加
        $calendarUrl = route('calendar.show', ['date' => now()->format('Y-m-d')]);

        // 完了したhabitの情報があればURLにクエリパラメータとして追加
        if (session()->has('completed_habit_id')) {
            $habitId = session('completed_habit_id');
            $calendarUrl .= "?completed_habit_id={$habitId}";

            Log::debug("Added completed habit info to calendar URL: {$calendarUrl}");
        }

        // セッションフラグを更新（次回のため）
        session(['current_level' => $nextLevel]); // 次回のために現在のレベルを保存

        try {
            // ビューファイル名を'completed'としてレンダリング
            return view('completed', [
                'currentLevel' => $currentLevel,
                'nextLevel' => $nextLevel,
                'today' => $today,
                'nextRewardLevel' => $nextRewardLevel,
                'isRewardLevel' => $isRewardLevel,
                'calendarUrl' => $calendarUrl // カレンダーURLを渡す
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to render completed view: " . $e->getMessage());

            // 緊急対応：ビューが見つからない場合はカレンダーにリダイレクト
            return redirect()->route('calendar.show', ['date' => now()->format('Y-m-d')]);
        }
    }

    /**
     * 次の報酬レベルを計算するメソッド - 修正版
     */
    private function calculateNextRewardLevel($level)
    {
        // レベルが3の倍数の場合は、次の3の倍数を返す
        if ($level % 3 == 0) {
            return $level + 3;
        }

        // そうでない場合は、次の3の倍数を返す
        $nextMultipleOf3 = ceil($level / 3) * 3;
        return $nextMultipleOf3;
    }

    /**
     * 現在のレベルが報酬レベル（3の倍数）かをチェック
     */
    private function isRewardLevel($level)
    {
        return $level % 3 == 0;
    }

    /**
     * Userモデルにlevelフィールドが存在するかチェック
     */
    private function hasLevelField()
    {
        try {
            $user = Auth::user();
            $user->level; // level属性にアクセスしてみる
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
