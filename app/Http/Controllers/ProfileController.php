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

            $path = $request->file('profile_photo')->store('public/profile_icons');
            $user->profile_photo_url = Storage::url($path);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'プロフィール画像を更新しました。');
    }
}



// namespace App\Http\Controllers;

// use App\Http\Requests\ProfileUpdateRequest;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Redirect;
// use Illuminate\View\View;

// class ProfileController extends Controller
// {
//     /**
//      * Display the user's profile form.
//      */
//     public function edit(Request $request): View
//     {
//         return view('profile.edit', [
//             'user' => $request->user(),
//         ]);
//     }

//     /**
//      * Update the user's profile information.
//      */
//     public function update(ProfileUpdateRequest $request): RedirectResponse
//     {
//         $request->user()->fill($request->validated());

//         if ($request->user()->isDirty('email')) {
//             $request->user()->email_verified_at = null;
//         }

//         $request->user()->save();

//         return Redirect::route('profile.edit')->with('status', 'profile-updated');
//     }

//     /**
//      * Delete the user's account.
//      */
//     public function destroy(Request $request): RedirectResponse
//     {
//         $request->validateWithBag('userDeletion', [
//             'password' => ['required', 'current_password'],
//         ]);

//         $user = $request->user();

//         Auth::logout();

//         $user->delete();

//         $request->session()->invalidate();
//         $request->session()->regenerateToken();

//         return Redirect::to('/');
//     }
// }
