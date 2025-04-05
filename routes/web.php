<?php

// 必要なクラスや関数をインポート
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginRecordController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\UserLevelController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HabitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RankingController;

/**
 * 認証関連のルート
 * Laravel のデフォルト認証機能（ログイン・登録など）を有効にするためのルートです。
 */
require __DIR__.'/auth.php';

/**
 * ホームページのルート
 * このルートは、アプリケーションのトップページ（'/'）にアクセスしたときに呼ばれます。
 * 'welcome' というビューを表示します。
 */
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home'); // 認証済みの場合、ホーム画面へリダイレクト
    }
    return view('welcome'); // resources/views/welcome.blade.php を表示
})->name('home');

/**
 * ダッシュボードページのルート
 * 認証済みユーザーのみがアクセスできます。
 * middleware(['auth', 'verified']) は、ログイン済みかつメール認証済みのユーザーのみ許可します。
 */
Route::get('/home', function () {
    return view('welcome_login'); // resources/views/welcome_login.blade.php を表示
})->middleware(['auth', 'verified'])->name('home');

/**
 * 認証済みユーザー向けのルートグループ
 * 以下のルートはすべて、middleware('auth') によって保護されています。
 */
Route::middleware('auth')->group(function () {
    /**
     * プロフィール編集ページ
     * プロフィールの編集・更新を行うためのルートです。
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // 編集画面を表示
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // 更新処理
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // 削除処理

    /**
     * 連続ログイン記録ページ
     * ユーザーの連続ログイン記録を表示するためのルートです。
     */
    Route::get('/login-record', [LoginRecordController::class, 'index'])->name('login.record');

    /**
     * ボーナスページ
     * ログインボーナスを表示するためのルートです。
     */
    Route::get('/bonus', [BonusController::class, 'show'])->name('bonus.show');

    /**
     * ペナルティーページ
     * ログインペナルティーを表示するためのルートです。
     */
    Route::get('/penalty', [PenaltyController::class, 'show'])->name('penalty.show');

    /**
     * 習慣設定画面（追加フォーム）
     * 習慣の追加フォームを表示するためのルートです。
     */
    Route::get('/add_habit', function () {
        return view('add_habit'); // resources/views/add_habit.blade.php
    })->name('add_habit');

    /**
     * 習慣の保存
     * 新しい習慣をデータベースに保存するためのルートです。
     */
    Route::post('/save_habit', [HabitController::class, 'store'])->name('save_habit');

    /**
     * 習慣の一覧表示
     * ユーザーの習慣一覧を表示するためのルートです。
     */
    Route::get('/set-routine', [HabitController::class, 'index'])->name('set-routine');

    /**
     * 習慣の削除
     * 指定された習慣を削除するためのルートです。
     */
    Route::get('/habits/{id}', [HabitController::class, 'destroy'])->name('delete-habit');

    /**
     * ランキングリストページ
     * ユーザーのランキングを表示するためのルートです。
     */
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking');

    /**
     * タスク関連ルート
     */
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/add-to-my-tasks', [TaskController::class, 'addToMyTasks'])->name('tasks.add-to-my-tasks');
    Route::delete('/tasks/{task}/remove-from-my-tasks', [TaskController::class, 'removeFromMyTasks'])->name('tasks.remove-from-my-tasks');

    /**
     * タスク完了処理
     */
    Route::post('/user-tasks/{userTask}/complete', [TaskController::class, 'completeTask'])->name('user-tasks.complete');

    /**
     * ルーティン関連ルート
     */
    Route::resource('routines', RoutineController::class);

    /**
     * レベル・実績
     */
    Route::get('/user-level', [UserLevelController::class, 'show'])->name('user-level.show');

    /**
     * カレンダー
     */
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/{date}', [CalendarController::class, 'show'])->name('calendar.show');
});

/**
 * ログアウト処理
 * POST リクエストを受け付け、セッションを破棄してホーム画面にリダイレクトします。
 */
Route::post('/logout', function () {
    auth()->logout(); // セッションを破棄
    return redirect('/'); // ホームページにリダイレクト
})->name('logout');

/**
 * GET リクエスト用のログアウト処理
 * 上記の POST リクエストと同様の処理を行います。
 */
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

/**
 * 新規登録ページ
 * 新規ユーザー登録フォームを表示および処理するためのルートです。
 */
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('registernew', [RegisterController::class, 'store'])->name('registernew');

/**
 * API: タスクデータ取得
 */
Route::get('/api/tasks/{year}/{month}', [TaskController::class, 'getTasks']);