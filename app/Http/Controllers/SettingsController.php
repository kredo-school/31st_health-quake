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

        // 名前とメールアドレスの更新
        $user->update($request->only('name', 'email'));

        // アイコン画像のアップロード処理（必要に応じて追加）
        if ($request->hasFile('profile_photo')) {
            // アイコン画像の保存処理
            $path = $request->file('profile_photo')->store('profile-photos', 'public'); // 'public'ディスクを使用
            $user->profile_photo_path = $path; // データベースにパスを保存
            $user->save();
        }

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