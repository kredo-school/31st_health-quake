<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginRecordController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\PenaltyController;
use Illuminate\Support\Facades\Route;

// ホームページ
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ダッシュボード（認証済みユーザーのみアクセス可能）
Route::get('/dashboard', function () {
    return view('welcome_login'); // welcome_login.blade.php を表示
})->middleware(['auth', 'verified'])->name('dashboard');

// プロフィール関連のルート（認証済みユーザーのみアクセス可能）
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 連続ログイン記録ページ
    Route::get('/login-record', [LoginRecordController::class, 'index'])->name('login.record');

    // ボーナスページ
    Route::get('/bonus', [BonusController::class, 'show'])->name('bonus.show');

    // ペナルティーページ
    Route::get('/penalty', [PenaltyController::class, 'show'])->name('penalty.show');
});

// ログアウト処理
Route::post('/logout', function () {
    auth()->logout(); // セッションを破棄
    return redirect('/'); // ホームページにリダイレクト
})->name('logout');

// 新規登録ページ
Route::get('/register', function () {
    return view('register');
})->name('register');

// 認証関連のルート（ログイン・登録など）
require __DIR__.'/auth.php';

// タスクカレンダーページ
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

// ランキングリストページ
Route::get('/ranking', [RankingController::class, 'index'])->name('ranking');

// プロフィール設定ページ
Route::get('/settings/profile', [SettingsController::class, 'profile'])->name('settings.profile');
Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');

// パスワード変更ページ
Route::get('/settings/password', [SettingsController::class, 'password'])->name('settings.password');
Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');