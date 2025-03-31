<?php

use Illuminate\Http\Request;
use App\Http\Controllers\HabitController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 認証が必要なルート
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // 削除エンドポイント
    Route::delete('/habits/{id}', [HabitController::class, 'destroy']);
});

// 認証不要なルート
Route::get('/tasks/{year}/{month}', [TaskController::class, 'getTasks']);
