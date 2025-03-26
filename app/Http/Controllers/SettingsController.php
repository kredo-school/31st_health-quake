<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    // プロフィール設定ページ
    public function profile()
    {
        return view('settings.profile');
    }

    // プロフィール更新処理
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only('name', 'email'));
        return redirect()->route('settings.profile')->with('success', 'プロフィールが更新されました。');
    }

    // パスワード変更ページ
    public function password()
    {
        return view('settings.password');
    }

    // パスワード更新処理
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (! Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => '現在のパスワードが正しくありません。']);
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('settings.password')->with('success', 'パスワードが更新されました。');
    }
}