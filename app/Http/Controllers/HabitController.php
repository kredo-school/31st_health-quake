<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Habit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HabitController extends Controller
{
    /**
     * Display the latest habits for the set-routine page
     */
    public function index()
    {
        // 未完了の習慣のみを取得するように修正
        $habits = Auth::user()->habits()
            ->where(function ($query) {
                $query->where('is_completed', '!=', 1)
                    ->orWhereNull('is_completed');
            })
            ->latest()
            ->take(4)
            ->get();

        Log::debug('HabitController@index called, found ' . $habits->count() . ' habits');

        // Pass habits to the view
        return view('routines.SetRoutine', compact('habits'));
    }

    /**
     * Delete the authenticated user's habit
     */
    public function destroy($id)
    {
        // Get the authenticated user's ID
        $user = Auth::id();

        // Search for the corresponding habit
        $habit = Habit::where('id', $id)
            ->where('user_id', $user)
            ->first();

        if (!$habit) {
            // Return error message if habit not found or unauthorized
            return redirect()->route('set-routine')
                ->with('error', 'Habit not found or you do not have permission to delete this habit');
        }

        // Delete the habit
        $habit->delete();

        // Redirect with success message
        return redirect()->route('set-routine')
            ->with('success', 'Habit has been deleted');
    }

    /**
     * Save a new habit
     */
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // 未完了の習慣数だけをカウントするように修正
        $incompleteHabitsCount = Auth::user()->habits()
            ->where(function ($query) {
                $query->where('is_completed', '!=', 1)
                    ->orWhereNull('is_completed');
            })
            ->count();

        if ($incompleteHabitsCount >= 3) {
            return redirect()->back()
                ->withErrors(['error' => 'You can only set up to 3 active habits.'])
                ->withInput();
        }

        // Assign user_id and save - デフォルト値の設定
        $validatedData['user_id'] = Auth::id();
        $validatedData['is_completed'] = false; // 初期状態は未完了
        Habit::create($validatedData);


        // Redirect with success message
        return redirect()->route('set-routine')
            ->with('success', 'Habit has been saved successfully.');
    }

    /**
     * タスク表示画面
     */
    public function showTask($id)
    {
        $habit = Habit::findOrFail($id);

        // 権限チェック
        if ($habit->user_id != Auth::id()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to view this habit.');
        }

        return view('habits.task', compact('habit'));
    }

    /**
     * 習慣の完了処理
     */
    public function complete(Request $request, $id)
    {
        $habit = Habit::findOrFail($id);

        // 権限チェック
        if ($habit->user_id != Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to complete this habit.'
            ], 403);
        }

        // 習慣を完了としてマーク - 整数値1を使用
        $habit->completed_at = Carbon::now();
        $habit->is_completed = 1;  // このフィールドを整数値で設定
        $habit->last_completed = Carbon::now();  // 最後に完了した日時も記録
        $habit->save();

        // ログに記録して確認
        Log::debug("Habit marked as complete - ID: {$habit->id}, is_completed: {$habit->is_completed}, completed_at: {$habit->completed_at}");

        // ユーザーのタスク達成数を増やす
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

        // レベルアップの条件をチェック（例：5タスクごとにレベルアップ）
        $shouldLevelUp = $habitsCompleted > 0 && $habitsCompleted % 5 == 0;

        Log::debug("Should level up? " . ($shouldLevelUp ? 'Yes' : 'No'));

        // ユーザーの現在のレベルを取得
        try {
            $currentLevel = $user->level ?? 1;

            // レベルアップする場合は次のレベルを計算して更新
            if ($shouldLevelUp) {
                $nextLevel = $currentLevel + 1;

                // DBにレベルフィールドがある場合は更新
                $user->level = $nextLevel;
                $user->save();

                Log::debug("User level updated: {$currentLevel} -> {$nextLevel}");
            } else {
                $nextLevel = $currentLevel;
            }
        } catch (\Exception $e) {
            // DBにlevelフィールドがない場合
            $currentLevel = session('user_level', 1);

            if ($shouldLevelUp) {
                $nextLevel = $currentLevel + 1;
                session(['user_level' => $nextLevel]);

                Log::debug("Session user_level updated: {$currentLevel} -> {$nextLevel}");
            } else {
                $nextLevel = $currentLevel;
            }
        }

        // レベル情報をセッションに保存（LevelControllerでの表示用）
        session(['current_level' => $currentLevel]);
        session(['next_level' => $nextLevel]);

        // 重要：カレンダーにタスク完了を記録するための情報をセッションに保存
        session(['completed_habit_id' => $habit->id]);
        session(['completed_habit_date' => $habit->date]);
        session(['completed_habit_name' => $habit->name]);
        session(['completed_habit_category' => $habit->category]);

        Log::debug("Habit completion recorded in session for calendar: habit_id={$habit->id}");

        // 常にレベルアップ画面へリダイレクト
        return response()->json([
            'success' => true,
            'message' => $shouldLevelUp ? 'Level up!' : 'Task completed',
            'redirectUrl' => route('level.up')
        ]);
    }

    /**
     * タスク完了の確認画面（タイマー付き）
     */
    public function done(Request $request, $id)
    {
        $habit = Habit::findOrFail($id);

        if ($habit->user_id != Auth::id()) {
            return redirect()->route('dashboard')
                ->with('error', 'You do not have permission to access this habit.');
        }

        return view('habits.done', compact('habit'));
    }
}
