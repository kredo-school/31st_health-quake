<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginRecordController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\LevelController; // 重要：追加
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\TimerController;
use App\Http\Controllers\RewardsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

// 認証ルート（Laravel BreezeやFortifyなどが生成するもの）
require __DIR__ . '/auth.php';

// ------------------------------------------------------
// 🔒 認証が必要なルート（authミドルウェア適用）
// ------------------------------------------------------
Route::middleware(['auth'])->group(function () {
    // プロフィール関連
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 連続ログイン記録
    Route::get('/login-record', [LoginRecordController::class, 'index'])->name('login.record');

    // ボーナス・ペナルティ
    Route::get('/bonus', [BonusController::class, 'showPaper'])->name('bonus.show');
    Route::get('/penalty', [PenaltyController::class, 'index'])->name('penalty.show');

    // 習慣
    Route::get('/add_habit', fn() => view('add_habit'))->name('add_habit');
    Route::post('/save_habit', [HabitController::class, 'store'])->name('save_habit');
    Route::get('/set-routine', [HabitController::class, 'index'])->name('set-routine');
    Route::get('/habits/{id}', [HabitController::class, 'destroy'])->name('delete-habit');
    Route::post('/habits/{id}/complete', [HabitController::class, 'complete'])->name('habits.complete');
    Route::get('/habits/{id}/done', [HabitController::class, 'done'])->name('habits.done');

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
     Route::get('/level-up', [App\Http\Controllers\LevelController::class, 'showLevelUp'])->name('level.up');

     Route::post('/habits/{id}/complete', [App\Http\Controllers\HabitController::class, 'complete'])->name('habits.complete');
     Route::get('/habits/{id}/done', [App\Http\Controllers\HabitController::class, 'done'])->name('habits.done');

    // カレンダー
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendarnew', [CalendarController::class, 'shownew'])->name('calendar.shownew');
    Route::get('/calendar/{date}', [CalendarController::class, 'show'])->name('calendar.show');
    // カレンダーから習慣を削除
    Route::delete('/calendar/habits/{id}', [CalendarController::class, 'deleteHabit'])->name('calendar.delete-habit');

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
    Route::get('/reward/earned/{level}', [RewardsController::class, 'earned'])->name('reward.earned');

    // API
    Route::get('/api/tasks/{year}/{month}', [TaskController::class, 'getTasks']);
});

// ログアウト処理（POSTのみ）
Route::post('/logout', function () {
    auth()->logout(); // ログアウト処理
    return redirect('/'); // ホームページにリダイレクト
})->name('logout');

// ------------------------------------------------------
// 🌐 公開ルート（認証不要）
// ------------------------------------------------------
Route::middleware([])->group(function () {
    // ホームページ
    Route::get('/', fn() => Auth::check() ? redirect()->route('home') : view('welcome'))->name('home');

    // 認証関係
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/registernew', [RegisterController::class, 'store'])->name('registernew');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // registernew に GET で来たら register にリダイレクト
    Route::get('/registernew', fn() => redirect()->route('register'));
});

// ホームページのランダムビュー
Route::get('/home', function () {
    // 表示するビューファイルの配列を定義
    $views = [
        'welcome_login',    // resources/views/welcome_login.blade.php
        'welcome_login_3',   // resources/views/welcome_login3.blade.php
        'welcome_login_4',   // resources/views/welcome_login4.blade.php
        'welcome_login_5',    // resources/views/welcome_login5.blade.php
    ];
    // 配列からランダムに1つのビューを選択
    $randomView = $views[array_rand($views)];
    // 選択されたビューを表示
    return view($randomView);
})->middleware(['auth', 'verified'])->name('home');


// ------------------------------------------------------
// 🔐 Admin 専用ルート（認証と管理者権限が必要）
// ------------------------------------------------------
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Admin ダッシュボード
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // ユーザー管理
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/search', [AdminController::class, 'searchUsers'])->name('admin.users.search'); // 検索機能
    Route::get('/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit'); // 編集画面表示
    Route::post('/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update'); // 更新処理
    Route::delete('/users/destroy/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy'); // 削除処理

    // ログインペナルティ設定
    Route::get('/login_penalties', [AdminController::class, 'loginPenalties'])->name('admin.login_penalties');
    Route::post('/login_penalties/update', [AdminController::class, 'updateLoginPenalties'])->name('admin.login_penalties.update');

    // カテゴリ管理
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories/update', [CategoryController::class, 'update'])->name('admin.categories.update');
    //Route::post('/categories/update', [AdminController::class, 'updateCategories'])->name('admin.categories.update');
});

// パスワードリセット関連のルート
Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])
    ->name('password.change');
Route::post('/change-password', [ChangePasswordController::class, 'updatePassword'])
    ->name('password.update');
