<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.passwords.email'); // 使用している Blade ファイルに合わせる
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // バリデーションルールを変更: email → username
        $request->validate([
            'username' => ['required', 'string'],
        ]);

        // ユーザー名を元にユーザーを検索
        $user = \App\Models\User::where('username', $request->input('username'))->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'username' => __('指定されたユーザー名は存在しません。'),
            ]);
        }

        // パスワードリセットリンクを送信
        $status = Password::sendResetLink(
            ['email' => $user->email] // メールアドレスが必要な場合は、データベースから取得
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withErrors(['username' => __($status)]);
    }
}