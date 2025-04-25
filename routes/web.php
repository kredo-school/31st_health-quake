<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// コントローラー
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginRecordController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CalendarControllernew;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\TimerController;
use App\Http\Controllers\RewardsController;

// 認証ルート（Laravel BreezeやFortifyなどが生成するもの）
require __DIR__.'/auth.php';

// ------------------------------------------------------
// 🔒 認証が必要なルート（authミドルウェア適用）
// ------------------------------------------------------
Route::middleware(['auth'])->group(function () {
    // ✅ プロフィール関連（route('profile') も動くよう明示）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 連続ログイン記録
    Route::get('/login-record', [LoginRecordController::class, 'index'])->name('login.record');

    // ボーナス・ペナルティ
    Route::get('/bonus', [BonusController::class, 'show'])->name('bonus.show');
    Route::get('/penalty', [PenaltyController::class, 'show'])->name('penalty.show');

    // 習慣
    Route::get('/add_habit', fn () => view('add_habit'))->name('add_habit');
    Route::post('/save_habit', [HabitController::class, 'store'])->name('save_habit');
    Route::get('/set-routine', [HabitController::class, 'index'])->name('set-routine');
    Route::get('/habits/{id}', [HabitController::class, 'destroy'])->name('delete-habit');

    // ランキング
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking');

    // タスク関連
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/add-to-my-tasks', [TaskController::class, 'addToMyTasks'])->name('tasks.add-to-my-tasks');
    Route::delete('/tasks/{task}/remove-from-my-tasks', [TaskController::class, 'removeFromMyTasks'])->name('tasks.remove-from-my-tasks');
    Route::post('/user-tasks/{userTask}/complete', [TaskController::class, 'completeTask'])->name('user-tasks.complete');

    // ルーティン
    Route::resource('routines', RoutineController::class);

    // レベル
    Route::get('/user-level', [UserLevelController::class, 'show'])->name('user-level.show');

    // カレンダー
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendarnew', [CalendarController::class, 'shownew'])->name('calendar.shownew');
    Route::get('/calendar/{date}', [CalendarController::class, 'show'])->name('calendar.show');
    Route::get('/calendar/calendarnew', [CalendarController::class, 'shownew'])->name('calendar.calendarnew');

    // タイマー
    Route::get('/timer/start', [TimerController::class, 'index'])->name('timer.start');
    Route::get('/timer/show', [TimerController::class, 'show'])->name('timer.show');
    Route::post('/timer/stop', [TimerController::class, 'stopTimer'])->name('timer.stop');
    Route::post('/timer/restart', [TimerController::class, 'restartTimer'])->name('timer.restart');
    Route::post('/set-routine/quit', [TimerController::class, 'quitTasks'])->name('set-routine.quit');
    Route::post('/timer/done', [TimerController::class, 'done'])->name('timer.done');

    // 報酬
    Route::get('/set-rewards', [RewardsController::class, 'index'])->name('rewards.index');
    Route::post('/set-rewards', [RewardsController::class, 'store'])->name('rewards.store');
    Route::get('/set-rewards/{id}/edit', [RewardsController::class, 'edit'])->name('rewards.edit');
    Route::put('/set-rewards/{id}', [RewardsController::class, 'update'])->name('rewards.update');
    Route::delete('/set-rewards/{id}', [RewardsController::class, 'destroy'])->name('rewards.destroy');
});

// ------------------------------------------------------
// 🌐 公開ルート
// ------------------------------------------------------

// ホームページ
Route::get('/', function () {
    return Auth::check() ? redirect()->route('home') : view('welcome');
})->name('home');

// 認証後のダッシュボード
Route::get('/home', fn () => view('welcome_login'))->middleware(['auth', 'verified'])->name('home');

// 認証関係
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('registernew', [RegisterController::class, 'store'])->name('registernew');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// ログアウト処理（GET or POST どちらでも対応）
Route::post('/logout', fn () => tap(auth()->logout(), fn () => redirect('/')))->name('logout');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// API
Route::get('/api/tasks/{year}/{month}', [TaskController::class, 'getTasks']);

// registernew に GET で来たら register にリダイレクト
Route::get('registernew', fn () => redirect()->route('register'));

