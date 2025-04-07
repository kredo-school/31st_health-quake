<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\UserLevelController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HabitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\RewardsController;

// 習慣設定画面（追加フォーム）
Route::get('/add_habit', function () {
    return view('add_habit'); // resources/views/add_habit.blade.php
})->name('add_habit');



// 習慣の保存
Route::post('/save_habit', [HabitController::class, 'store'])->name('save_habit');

// 習慣の一覧表示
Route::get('/set-routine', [HabitController::class, 'index'])->name('set-routine');

// トップページ（ログイン状態による振り分け）
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
});
Route::get('/habits/{id}', [HabitController::class, 'destroy'])->name('delete-habit');


// 認証ルート
Auth::routes();

// ダッシュボード
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::get('/api/tasks/{year}/{month}', [TaskController::class, 'getTasks']);

// タスク関連ルート
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create')->middleware('auth');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store')->middleware('auth');
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
Route::post('/tasks/{task}/add-to-my-tasks', [TaskController::class, 'addToMyTasks'])->name('tasks.add-to-my-tasks')->middleware('auth');
Route::delete('/tasks/{task}/remove-from-my-tasks', [TaskController::class, 'removeFromMyTasks'])->name('tasks.remove-from-my-tasks')->middleware('auth');

// タスク完了処理
Route::post('/user-tasks/{userTask}/complete', [TaskController::class, 'completeTask'])->name('user-tasks.complete')->middleware('auth');

// ルーティン関連ルート
Route::resource('routines', RoutineController::class)->middleware('auth');

// レベル・実績
Route::get('/user-level', [UserLevelController::class, 'show'])->name('user-level.show')->middleware('auth');

// カレンダー
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index')->middleware('auth');
Route::get('/calendar/{date}', [CalendarController::class, 'show'])->name('calendar.show')->middleware('auth');



Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('/ranking', [RankingController::class, 'index']);


// 報酬関連ルート
Route::get('/set-rewards', [RewardsController::class, 'index'])->name('rewards.index');
Route::post('/set-rewards', [RewardsController::class, 'store'])->name('rewards.store');
Route::get('/set-rewards/{id}/edit', [RewardsController::class, 'edit'])->name('rewards.edit');
Route::put('/set-rewards/{id}', [RewardsController::class, 'update'])->name('rewards.update');
Route::delete('/set-rewards/{id}', [RewardsController::class, 'destroy'])->name('rewards.destroy');


