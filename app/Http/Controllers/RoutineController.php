<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use App\Models\Task;
use App\Models\UserTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoutineController extends Controller
{
    /**
     * コンストラクタ - 認証チェック
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ルーティン一覧画面を表示
     */
    public function index()
    {
        $routines = Auth::user()->routines;
        return view('routines.index', compact('routines'));
    }

    /**
     * ルーティン作成画面を表示
     */
    public function create()
    {
        // ユーザーのタスクを取得
        $userTaskIds = UserTask::where('user_id', Auth::id())->pluck('task_id');
        $tasks = Task::whereIn('id', $userTaskIds)->get();

        return view('routines.create', compact('tasks'));
    }

    /**
     * ルーティンを保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'type' => 'required|in:朝,昼,夜,その他',
            'estimated_duration' => 'nullable|integer|min:1',
            'tasks' => 'array',
            'tasks.*' => 'integer|exists:tasks,id',
        ]);

        $routine = new Routine();
        $routine->user_id = Auth::id();
        $routine->name = $request->name;
        $routine->description = $request->description;
        $routine->start_time = $request->start_time;
        $routine->type = $request->type;
        $routine->estimated_duration = $request->estimated_duration;
        $routine->is_active = true;
        $routine->save();

        // タスクを追加
        if ($request->has('tasks')) {
            $order = 1;
            foreach ($request->tasks as $taskId) {
                $task = Task::find($taskId);

                UserTask::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'task_id' => $taskId,
                        'routine_id' => $routine->id
                    ],
                    [
                        'order' => $order,
                        'points' => $task->default_points,
                    ]
                );

                $order++;
            }
        }

        return redirect()->route('routines.index')
            ->with('success', 'ルーティンが作成されました');
    }

    /**
     * ルーティン詳細画面を表示
     */
    public function show(Routine $routine)
    {
        // 権限チェック
        $this->authorizeRoutine($routine);

        // ルーティンに関連するタスクを取得
        $routineTasks = UserTask::where('routine_id', $routine->id)
            ->where('user_id', Auth::id())
            ->orderBy('order')
            ->with('task')
            ->get();

        return view('routines.show', compact('routine', 'routineTasks'));
    }

    /**
     * ルーティン編集画面を表示
     */
    public function edit(Routine $routine)
    {
        // 権限チェック
        $this->authorizeRoutine($routine);

        // ユーザーのタスクを取得
        $userTaskIds = UserTask::where('user_id', Auth::id())->pluck('task_id');
        $tasks = Task::whereIn('id', $userTaskIds)->get();

        // ルーティンに含まれるタスクIDを取得
        $routineTaskIds = UserTask::where('routine_id', $routine->id)
            ->where('user_id', Auth::id())
            ->orderBy('order')
            ->pluck('task_id')
            ->toArray();

        return view('routines.edit', compact('routine', 'tasks', 'routineTaskIds'));
    }

    /**
     * ルーティンを更新
     */
    public function update(Request $request, Routine $routine)
    {
        // 権限チェック
        $this->authorizeRoutine($routine);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'type' => 'required|in:朝,昼,夜,その他',
            'estimated_duration' => 'nullable|integer|min:1',
            'tasks' => 'array',
            'tasks.*' => 'integer|exists:tasks,id',
        ]);

        $routine->name = $request->name;
        $routine->description = $request->description;
        $routine->start_time = $request->start_time;
        $routine->type = $request->type;
        $routine->estimated_duration = $request->estimated_duration;
        $routine->save();

        // 既存のタスクをルーティンから削除
        UserTask::where('routine_id', $routine->id)
            ->where('user_id', Auth::id())
            ->update(['routine_id' => null]);

        // タスクを追加
        if ($request->has('tasks')) {
            $order = 1;
            foreach ($request->tasks as $taskId) {
                $task = Task::find($taskId);

                UserTask::updateOrCreate(
                    [
                        'user_id' => Auth::id(),
                        'task_id' => $taskId,
                    ],
                    [
                        'routine_id' => $routine->id,
                        'order' => $order,
                        'points' => $task->default_points,
                    ]
                );

                $order++;
            }
        }

        return redirect()->route('routines.index')
            ->with('success', 'ルーティンが更新されました');
    }

    /**
     * ルーティンを削除
     */
    public function destroy(Routine $routine)
    {
        // 権限チェック
        $this->authorizeRoutine($routine);

        // ルーティンIDを持つUserTasksを更新
        UserTask::where('routine_id', $routine->id)
            ->where('user_id', Auth::id())
            ->update(['routine_id' => null]);

        // ルーティンを削除
        $routine->delete();

        return redirect()->route('routines.index')
            ->with('success', 'ルーティンが削除されました');
    }

    /**
     * 今日のルーティンを開始
     */
    public function start(Routine $routine)
    {
        // 権限チェック
        $this->authorizeRoutine($routine);

        // ルーティンに関連するタスクを取得
        $routineTasks = UserTask::where('routine_id', $routine->id)
            ->where('user_id', Auth::id())
            ->orderBy('order')
            ->with('task')
            ->get();

        return view('routines.start', compact('routine', 'routineTasks'));
    }

    /**
     * ルーティンに対する権限をチェック
     */
    private function authorizeRoutine(Routine $routine)
    {
        if ($routine->user_id !== Auth::id()) {
            abort(403, '権限がありません');
        }
    }
}
