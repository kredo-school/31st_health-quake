<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Habit;
use App\Models\UserTask;
use Illuminate\Support\Facades\Auth;

class TimerController extends Controller
{
    public function index(Request $request)
    {
        $duration = $request->input('duration', 300);
        $habitName = $request->input('name', 'Default Habit');
        $category = $request->input('category', 'Default Category');
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));

        session()->put('timer_start', Carbon::now());
        session()->put('timer_duration', $duration);
        session()->put('habit_name', $habitName);
        session()->put('category', $category);
        session()->put('date', $date);
        session()->put('is_timer_running', true);

        return redirect()->route('timer.show');
    }

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

    public function stopTimer()
    {
        session()->put('is_timer_running', false);
        return redirect()->route('timer.show');
    }

    public function restartTimer()
    {
        $elapsedTime = session('elapsed_time', 0);
        $newStartTime = Carbon::now()->subSeconds($elapsedTime);

        session()->put('timer_start', $newStartTime);
        session()->put('is_timer_running', true);

        return redirect()->route('timer.show');
    }

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

    public function done(Request $request)
    {
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
        } else {
            // Habitが存在しない場合は新規作成
            $habit = new Habit();
            $habit->user_id = $userId;
            $habit->name = $request->name ?: $habitName;
            $habit->category = $request->category ?: $category;
            $habit->is_completed = 1;
            $habit->last_completed = now();
            $habit->save();
        }

        // ユーザーの習慣達成数を更新
        $user = Auth::user();

        // 習慣達成カウント処理
        try {
            // DBにhabits_completedフィールドがある場合
            $user->habits_completed = ($user->habits_completed ?? 0) + 1;
            $user->save();

            $habitsCompleted = $user->habits_completed;
        } catch (\Exception $e) {
            // DBにhabits_completedフィールドがない場合
            $habitsCompleted = session('habits_completed', 0) + 1;
            session(['habits_completed' => $habitsCompleted]);
        }

        // レベルアップ条件をチェック (5回達成ごと)
        if ($habitsCompleted % 5 == 0) {
            // 現在のレベルと次のレベルを計算
            try {
                $currentLevel = $user->level ?? 1;
                $nextLevel = $currentLevel + 1;

                // DBにレベルフィールドがある場合は更新
                $user->level = $nextLevel;
                $user->save();
            } catch (\Exception $e) {
                // DBにlevelフィールドがない場合
                $currentLevel = session('user_level', 1);
                $nextLevel = $currentLevel + 1;
                session(['user_level' => $nextLevel]);
            }

            // レベル情報をセッションに保存（LevelControllerでの表示用）
            session(['current_level' => $currentLevel]);
            session(['next_level' => $nextLevel]);

            // レベルアップ画面へリダイレクト
            return redirect()->route('level.up');
        }

        // 通常はカレンダー画面へリダイレクト
        return redirect()->route('calendar.show', ['date' => $today]);
    }
}
