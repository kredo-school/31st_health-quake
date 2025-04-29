<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Habit;
use App\Models\User;
use Carbon\Carbon;

class HabitController extends Controller
{
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
     * Display the latest 4 habits
     */
    public function index()
    {
        // Retrieve latest 4 habits for the authenticated user
        $habits = Auth::user()->habits()
            ->latest()
            ->take(4)
            ->get();

        // Pass habits to the view
        return view('routines.SetRoutine', compact('habits'));
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

        // Check habit count before saving
        $currentHabitsCount = Auth::user()->habits()->count();

        if ($currentHabitsCount >= 3) {
            return redirect()->back()
                ->withErrors(['error' => 'You can only set up to 3 habits.'])
                ->withInput();
        }

        // Assign user_id and save
        $validatedData['user_id'] = Auth::id();
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

        // 習慣を完了としてマーク
        $habit->completed_at = Carbon::now();
        $habit->save();

        // ユーザーのタスク達成数を増やす
        $user = Auth::user();

        // habits_completedカラムがない場合のエラー処理
        try {
            $user->habits_completed = ($user->habits_completed ?? 0) + 1;
            $user->save();
        } catch (\Exception $e) {
            // エラーログを出力
            \Log::error('Error updating habits_completed: ' . $e->getMessage());

            // habits_completedカラムが存在しない場合は、このステップをスキップ
            // レベルアップ処理はセッションで管理
        }

        // レベルアップの条件をチェック（例：5タスクごとにレベルアップ）
        $habitsCompleted = $user->habits_completed ?? session('habits_completed', 0);

        if (!isset($user->habits_completed)) {
            // セッションで管理している場合はインクリメント
            session(['habits_completed' => $habitsCompleted + 1]);
            $habitsCompleted = session('habits_completed');
        }

        $shouldLevelUp = $habitsCompleted > 0 && $habitsCompleted % 5 == 0;

        if ($shouldLevelUp) {
            // レベルアップが必要な場合
            session(['level_up_needed' => true]);
            return response()->json([
                'success' => true,
                'shouldLevelUp' => true,
                'redirectUrl' => route('level.up')
            ]);
        } else {
            // 通常のカレンダーページにリダイレクト
            return response()->json([
                'success' => true,
                'shouldLevelUp' => false,
                'redirectUrl' => route('calendar.show')
            ]);
        }
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
