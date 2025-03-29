<?php

// 必要なクラスや関数をインポート
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginRecordController;
use App\Http\Controllers\BonusController;
use App\Http\Controllers\PenaltyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/**
 * ホームページのルート
 * このルートは、アプリケーションのトップページ（'/'）にアクセスしたときに呼ばれます。
 * 'welcome' というビューを表示します。
 */
Route::get('/', function () {
    return view('welcome'); // resources/views/welcome.blade.php を表示
})->name('home'); // ルート名を 'home' として定義

/**
 * ダッシュボードページのルート
 * 認証済みユーザーのみがアクセスできます。
 * middleware(['auth', 'verified']) は、ログイン済みかつメール認証済みのユーザーのみ許可します。
 */
Route::get('/dashboard', function () {
    return view('welcome_login'); // resources/views/welcome_login.blade.php を表示
})->middleware(['auth', 'verified'])->name('dashboard'); // ルート名を 'dashboard' として定義

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
});

/**
 * ログアウト処理
 * POST リクエストを受け付け、セッションを破棄してホーム画面にリダイレクトします。
 */
Route::post('/logout', function () {
    auth()->logout(); // セッションを破棄
    return redirect('/'); // ホームページにリダイレクト
})->name('logout'); // ルート名を 'logout' として定義

/**
 * GET リクエスト用のログアウト処理
 * 上記の POST リクエストと同様の処理を行います。
 */
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

/**
 * 新規登録ページ
 * 新規ユーザー登録フォームを表示するためのルートです。
 */
Route::get('/register', function () {
    return view('register'); // resources/views/register.blade.php を表示
})->name('register'); // ルート名を 'register' として定義

/**
 * 認証関連のルート
 * Laravel のデフォルト認証機能（ログイン・登録など）を有効にするためのルートです。
 */
require __DIR__.'/auth.php';

/**
 * タスクカレンダーページ
 * タスク管理用のカレンダーを表示するためのルートです。
 */
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

/**
 * ランキングリストページ
 * ユーザーのランキングを表示するためのルートです。
 */
Route::get('/ranking', [RankingController::class, 'index'])->name('ranking');

/**
 * プロフィール設定ページ
 * プロフィール情報を設定・更新するためのルートです。
 */
Route::get('/settings/profile', [SettingsController::class, 'profile'])->name('settings.profile');
Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');

/**
 * パスワード変更ページ
 * パスワードを変更するためのルートです。
 */
Route::get('/settings/password', [SettingsController::class, 'password'])->name('settings.password');
Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');

/**
 * ログインページ
 * ログインフォームを表示および処理するためのルートです。
 */
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); // ログインフォームを表示
Route::post('/login', [LoginController::class, 'login'])->name('login.post'); // ログイン処理