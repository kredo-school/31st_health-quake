<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Habit;
use Illuminate\Support\Facades\Auth;

class TimerController extends Controller
{
    /**
     * タイマーページを表示するアクション
     */
    public function index(Request $request)
    {
        // クエリパラメータから総時間を取得（デフォルトは300秒）
        $duration = $request->input('duration', 300);

        // タスク名とカテゴリ、日付を取得
        $habitName = $request->input('name', 'Default Habit');
        $category = $request->input('category', 'Default Category');
        $date = $request->input('date', Carbon::now()->format('Y-m-d')); // 現在の日付をデフォルト値として設定

        // セッションにタイマーの開始時刻、総時間、タスク名、カテゴリ、フラグ、日付を保存
        session()->put('timer_start', Carbon::now()); // タイマー開始時間
        session()->put('timer_duration', $duration); // タイマーの総時間（秒）
        session()->put('habit_name', $habitName); // タスク名
        session()->put('category', $category); // カテゴリ
        session()->put('date', $date); // 日付
        session()->put('is_timer_running', true); // タイマーが動作中であることを示すフラグ

        return redirect()->route('timer.show'); // タイマーページにリダイレクト
    }

    /**
     * タイマーページを表示するアクション
     */
    public function show()
    {
        // セッションからデータを取得
        $startTime = session('timer_start');
        $isRunning = session('is_timer_running', true); // フラグを取得（デフォルトは true）
        $habitName = session('habit_name', 'Default Habit');
        $category = session('category', 'Default Category');
        $date = session('date', Carbon::now()->format('Y-m-d')); // 日付を取得

        if ($startTime && $isRunning) {
            $elapsedTime = Carbon::now()->diffInSeconds($startTime); // 経過時間（秒）
        } else {
            $elapsedTime = session('elapsed_time', 0); // 停止中の場合、保存された経過時間を使用
        }

        // 経過時間をセッションに保存
        session()->put('elapsed_time', $elapsedTime);

        // 残り時間を計算
        $duration = session('timer_duration');
        $remainingTime = max(0, $duration - $elapsedTime);

        // 残り時間が0になったら終了
        if ($remainingTime <= 0 || !$isRunning) {
            return view('timer', [
                'timeCount' => sprintf('%d:%02d', floor($remainingTime / 60), $remainingTime % 60),
                'habitName' => $habitName,
                'category' => $category,
                'date' => $date,
            ]);
        }

        // 残り時間をフォーマット
        $minutes = floor($remainingTime / 60);
        $seconds = $remainingTime % 60;

        // ビューにデータを渡す
        return view('timer', [
            'timeCount' => sprintf('%d:%02d', $minutes, $seconds), // 分:秒の形式で表示
            'habitName' => $habitName, // タスク名
            'category' => $category, // カテゴリ
            'date' => $date, // 日付
        ]);
    }

    /**
     * タイマーを停止するアクション
     */
    public function stopTimer()
    {
        session()->put('is_timer_running', false); // タイマーを停止
        return redirect()->route('timer.show'); // タイマーページにリダイレクト
    }

    /**
     * タイマーを再開するアクション
     */
    public function restartTimer()
    {
        // 経過時間を取得
        $elapsedTime = session('elapsed_time', 0);

        // 新しい開始時刻を計算
        $newStartTime = Carbon::now()->subSeconds($elapsedTime);

        // セッションを更新
        session()->put('timer_start', $newStartTime);
        session()->put('is_timer_running', true); // タイマーを再開

        return redirect()->route('timer.show'); // タイマーページにリダイレクト
    }

    /**
     * Quit Tasks のアクション
     */
    public function quitTasks()
    {
        // 必要に応じて処理を記述（例: セッションのクリアなど）
        session()->forget(['timer_start', 'timer_duration', 'habit_name', 'category', 'date']);
        return redirect('/'); // トップページにリダイレクト
    }

    /**
     * DONEボタンを押したときのアクション
     */
    public function done(Request $request)
    {
    
        Habit::create([
            'user_id' => Auth::id(),
             'name' => $request['name'],
            'category' => $request['category'],
            'date' => Carbon::now()->format('Y-m-d') , 
        ]);
    

        // 現在の日付を取得
        $date = session('date', Carbon::now()->format('Y-m-d'));

        // calendarページにリダイレクト（パラメータを渡す）
        return redirect()->route('calendar.show', ['date' => $date]);
    }
}