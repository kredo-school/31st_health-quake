<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Habit;
use App\Models\UserTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TimerController extends Controller
{
    /**
     * タイマーを開始するための処理
     */
    public function index(Request $request)
    {
        Log::debug('TimerController@index called');

        // リクエストからデータを取得
        $duration = $request->input('duration', 300); // デフォルト5分（300秒）
        $habitName = $request->input('name', 'Default Habit');
        $category = $request->input('category', 'Default Category');
        $date = $request->input('date', Carbon::now()->format('Y-m-d H:i:s'));

        Log::debug("Timer settings - Duration: {$duration}, Name: {$habitName}, Category: {$category}, Date: {$date}");

        // タイマーデータをセッションに保存
        session([
            'timer_start' => Carbon::now(),
            'timer_duration' => $duration,
            'habit_name' => $habitName,
            'category' => $category,
            'date' => $date,
            'is_timer_running' => true
        ]);

        // タイマー表示画面にリダイレクト
        return redirect()->route('timer.show');
    }

    /**
     * タイマーの表示処理
     */
    public function show()
    {
        $startTime = session('timer_start');
        $isRunning = session('is_timer_running', true);
        $habitName = session('habit_name', 'Default Habit');
        $category = session('category', 'Default Category');
        $date = session('date', Carbon::now()->format('Y-m-d'));

        if ($startTime && $isRunning) {
            $elapsedTime = Carbon::parse($startTime)->diffInSeconds(Carbon::now());
        } else {
            $elapsedTime = session('elapsed_time', 0);
        }

        session()->put('elapsed_time', $elapsedTime);

        $minutes = floor($elapsedTime / 60);
        $seconds = $elapsedTime % 60;
        $formattedTime = sprintf('%d:%02d', $minutes, $seconds);

        return view('timer', [
            'timeCount' => $formattedTime,
            'habitName' => $habitName,
            'category' => $category,
            'date' => $date,
        ]);
    }

    /**
     * タイマーを停止する処理
     */
    public function stopTimer()
    {
        session()->put('is_timer_running', false);
        return redirect()->route('timer.show');
    }

    /**
     * タイマーを再開する処理
     */
    public function restartTimer()
    {
        $elapsedTime = session('elapsed_time', 0);
        $newStartTime = Carbon::now()->subSeconds($elapsedTime);

        session()->put('timer_start', $newStartTime);
        session()->put('is_timer_running', true);

        return redirect()->route('timer.show');
    }

    /**
     * タスクを終了する処理
     */
    public function quitTasks()
    {
        session()->forget([
            'timer_start',
            'timer_duration',
            'habit_name',
            'category',
            'date',
            'elapsed_time',
            'is_timer_running'
        ]);

        return redirect('/');
    }

    /**
     * タスク完了処理
     */
    public function done(Request $request)
    {
        Log::debug('Timer done method called');

        $userId = Auth::id();
        $today = Carbon::now()->toDateString();

        // タイマー関連セッションをクリア（必要な情報は保持）
        $habitName = session('habit_name', $request->name);
        $category = session('category', $request->category);

        session()->forget([
            'timer_start',
            'timer_duration',
            'elapsed_time',
            'is_timer_running'
        ]);

        // UserTaskを完了済みにする
        $userTask = UserTask::where('user_id', $userId)
            ->whereHas('task', function ($q) use ($request) {
                $q->where('name', $request->name);
            })
            ->where('is_completed', false)
            ->orderBy('updated_at', 'desc')
            ->first();

        if ($userTask) {
            $userTask->is_completed = true;
            $userTask->last_completed_at = Carbon::now();
            $userTask->save();
            Log::debug("User task marked as complete: {$userTask->id}");
        }

        // Habitも更新または新規作成
        $habit = Habit::where('user_id', $userId)
            ->where('name', $request->name ?: $habitName)
            ->where('category', $request->category ?: $category)
            ->first();

        if ($habit) {
            $habit->is_completed = 1;
            $habit->last_completed = now();
            $habit->save();
            Log::debug("Habit updated: {$habit->id}");
        } else {
            // Habitが存在しない場合は新規作成
            $habit = new Habit();
            $habit->user_id = $userId;
            $habit->name = $request->name ?: $habitName;
            $habit->category = $request->category ?: $category;
            $habit->is_completed = 1;
            $habit->last_completed = now();
            $habit->save();
            Log::debug("New habit created: {$habit->id}");
        }

        // ユーザーの習慣達成数を更新
        $user = Auth::user();

        // 習慣達成カウント処理
        $habitsCompleted = 0;

        try {
            // DBにhabits_completedフィールドがある場合
            $user->habits_completed = ($user->habits_completed ?? 0) + 1;
            $user->save();
            $habitsCompleted = $user->habits_completed;
            Log::debug("User habits_completed updated: {$habitsCompleted}");
        } catch (\Exception $e) {
            // DBにhabits_completedフィールドがない場合
            $habitsCompleted = session('habits_completed', 0) + 1;
            session(['habits_completed' => $habitsCompleted]);
            Log::debug("Session habits_completed updated: {$habitsCompleted}");
        }

        // レベルアップ条件をチェック (5回達成ごと)
        $shouldLevelUp = $habitsCompleted % 5 == 0;
        Log::debug("Should level up? " . ($shouldLevelUp ? 'Yes' : 'No') . " (habits completed: {$habitsCompleted})");

        if ($shouldLevelUp) {
            // 現在のレベルと次のレベルを計算
            try {
                $currentLevel = $user->level ?? 1;
                $nextLevel = $currentLevel + 1;

                // DBにレベルフィールドがある場合は更新
                $user->level = $nextLevel;
                $user->save();
                Log::debug("User level updated: {$currentLevel} -> {$nextLevel}");
            } catch (\Exception $e) {
                // DBにlevelフィールドがない場合
                $currentLevel = session('user_level', 1);
                $nextLevel = $currentLevel + 1;
                session(['user_level' => $nextLevel]);
                Log::debug("Session user_level updated: {$currentLevel} -> {$nextLevel}");
            }

            // レベル情報をセッションに保存（LevelControllerでの表示用）
            session(['current_level' => $currentLevel]);
            session(['next_level' => $nextLevel]);
            session(['level_up_needed' => true]);

            Log::debug("Redirecting to level.up route");

            // 強制的にレベルアップ画面へリダイレクト
            return redirect()->route('level.up');
        }

        Log::debug("Redirecting to calendar.show route with date: {$today}");
        // 常にレベルアップ画面へリダイレクト（条件に関わらず）
        return redirect()->route('level.up');
    }
}
