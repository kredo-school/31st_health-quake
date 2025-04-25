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

        // UserTaskを完了済みにする（最も新しい一致する未完了のタスクを対象）
        $userTask = \App\Models\UserTask::where('user_id', $userId)
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

        // 重複チェック後にHabitも作成
        $habit = Habit::where('user_id', $userId)
    ->where('name', $request->name)
    ->where('category', $request->category)
    // ->whereDate('date', $today)
    ->first();
if ($habit) {
    $habit->is_completed = 1;
    $habit->last_completed = now(); // or use Carbon::now()
    $habit->save();
}

        return redirect()->route('calendar.show', ['date' => $today]);
    }
}