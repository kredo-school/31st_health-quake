<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\Routine;
use App\Models\Task;
use App\Models\UserLevel;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // ユーザーのレベル情報を取得
        $userLevel = UserLevel::firstOrCreate(
            ['user_id' => $user->id],
            [
                'level' => 1,
                'experience_points' => 0,
                'points_to_next_level' => 100,
                'total_points_earned' => 0,
                'badges' => json_encode([]),
                'login_streak' => 0
            ]
        );

        // ユーザーのルーティンを取得
        $routines = Routine::where('user_id', $user->id)
            ->where('is_active', true)
            ->with(['tasks' => function ($query) {
                $query->orderBy('user_tasks.order');
            }])
            ->get();

        // 統計情報の取得
        $today = now()->format('Y-m-d');

        // 完了したタスク数
        $completedTasksCount = UserTask::where('user_id', $user->id)
            ->where('is_completed', true)
            ->count();

        // 連続達成日数（最大の連続日数を取得）
        $consecutiveDays = UserTask::where('user_id', $user->id)
            ->max('consecutive_days');

        // 現在の習慣数
        $activeTasks = UserTask::where('user_id', $user->id)
            ->count();

        // カテゴリごとの完了率
        $foodTasksCount = UserTask::where('user_id', $user->id)
            ->whereHas('task', function ($query) {
                $query->where('category', '食事');
            })
            ->count();

        $foodTasksCompletedCount = UserTask::where('user_id', $user->id)
            ->where('is_completed', true)
            ->whereHas('task', function ($query) {
                $query->where('category', '食事');
            })
            ->count();

        $foodTasksCompletionRate = $foodTasksCount > 0 ? round(($foodTasksCompletedCount / $foodTasksCount) * 100) : 0;

        // 睡眠カテゴリの完了率
        $sleepTasksCount = UserTask::where('user_id', $user->id)
            ->whereHas('task', function ($query) {
                $query->where('category', '睡眠');
            })
            ->count();

        $sleepTasksCompletedCount = UserTask::where('user_id', $user->id)
            ->where('is_completed', true)
            ->whereHas('task', function ($query) {
                $query->where('category', '睡眠');
            })
            ->count();

        $sleepTasksCompletionRate = $sleepTasksCount > 0 ? round(($sleepTasksCompletedCount / $sleepTasksCount) * 100) : 0;

        // 運動カテゴリの完了率
        $exerciseTasksCount = UserTask::where('user_id', $user->id)
            ->whereHas('task', function ($query) {
                $query->where('category', '運動');
            })
            ->count();

        $exerciseTasksCompletedCount = UserTask::where('user_id', $user->id)
            ->where('is_completed', true)
            ->whereHas('task', function ($query) {
                $query->where('category', '運動');
            })
            ->count();

        $exerciseTasksCompletionRate = $exerciseTasksCount > 0 ? round(($exerciseTasksCompletedCount / $exerciseTasksCount) * 100) : 0;

        return view('dashboard.index', compact(
            'userLevel',
            'routines',
            'completedTasksCount',
            'consecutiveDays',
            'activeTasks',
            'foodTasksCompletionRate',
            'sleepTasksCompletionRate',
            'exerciseTasksCompletionRate'
        ));
    }
}
