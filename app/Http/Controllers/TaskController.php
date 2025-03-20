<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * コンストラクタ - 認証チェック
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * タスク一覧画面を表示
     */
    public function index()
    {
        $tasks = Task::all();
        $userTasks = collect();

        if (Auth::check()) {
            // UserTask経由で取得
            $userTaskIds = UserTask::where('user_id', Auth::id())->pluck('task_id');
            $userTasks = Task::whereIn('id', $userTaskIds)->get();
        }

        return view('tasks.index', compact('tasks', 'userTasks'));
    }

    /**
     * タスク作成画面を表示
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * タスクを保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scientific_evidence' => 'nullable|string',
            'category' => 'required|in:食事,睡眠,運動,その他',
            'default_points' => 'required|integer|min:1',
            'has_timer' => 'boolean',
            'timer_duration' => 'nullable|integer|min:1',
            'benefits' => 'nullable|string',
        ]);

        $task = Task::create($request->all());

        if ($request->add_to_my_tasks) {
            UserTask::create([
                'user_id' => Auth::id(),
                'task_id' => $task->id,
                'points' => $task->default_points,
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', 'タスクが作成されました');
    }

    /**
     * タスク詳細画面を表示
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * タスク編集画面を表示
     */
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    /**
     * タスクを更新
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scientific_evidence' => 'nullable|string',
            'category' => 'required|in:食事,睡眠,運動,その他',
            'default_points' => 'required|integer|min:1',
            'has_timer' => 'boolean',
            'timer_duration' => 'nullable|integer|min:1',
            'benefits' => 'nullable|string',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'タスクが更新されました');
    }

    /**
     * タスクを削除
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'タスクが削除されました');
    }

    /**
     * タスクをユーザーのリストに追加
     */
    public function addToMyTasks(Task $task)
    {
        $userTask = UserTask::firstOrCreate([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
        ], [
            'points' => $task->default_points,
        ]);

        return redirect()->back()
            ->with('success', 'タスクがあなたのリストに追加されました');
    }

    /**
     * タスクをユーザーのリストから削除
     */
    public function removeFromMyTasks(Task $task)
    {
        // 直接中間テーブルから削除
        UserTask::where('user_id', Auth::id())
            ->where('task_id', $task->id)
            ->delete();

        return redirect()->back()
            ->with('success', 'タスクがあなたのリストから削除されました');
    }

    /**
     * タスクを完了としてマーク
     */
    public function completeTask(UserTask $userTask)
    {
        // ユーザーに属するタスクか確認
        if ($userTask->user_id !== Auth::id()) {
            return redirect()->back()->with('error', '権限がありません');
        }

        $userTask->is_completed = true;
        $userTask->last_completed_at = now();
        $userTask->consecutive_days += 1;
        $userTask->completion_count += 1;
        $userTask->save();

        // ユーザーのレベルにポイントを追加
        $userLevel = Auth::user()->userLevel;
        $userLevel->experience_points += $userTask->points ?? $userTask->task->default_points;
        $userLevel->total_points_earned += $userTask->points ?? $userTask->task->default_points;
        $userLevel->save();

        // レベルアップチェック
        $userLevel->levelUp();

        return redirect()->back()
            ->with('success', 'タスクが完了としてマークされました');
    }
}
