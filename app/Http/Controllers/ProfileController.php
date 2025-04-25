<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // プロフィール編集画面の表示
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    // プロフィール画像の更新処理
    public function update(Request $request)
    {
        $request->validate([
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            // 古い画像があれば削除
            if ($user->profile_photo_url && str_starts_with($user->profile_photo_url, '/storage')) {
                $oldPath = str_replace('/storage/', 'public/', $user->profile_photo_url);
                Storage::delete($oldPath);
            }

            // 画像を保存し、URLを取得
            $file = $request->file('profile_photo');
            $path = $file->store('profile-photos', 'public'); // ディレクトリ名を 'profile-photos' に統一
            $user->profile_photo_url = Storage::url($path);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Updated the image.');
    }
}