<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $users = User::all(); // Fetch all users from the database
        return view('admin.dashboard', compact('users'));
    }

    /**
     * Show the user management page.
     */
    public function users()
    {
        $users = User::all(); // Fetch all users from the database
        return view('admin.users', compact('users'));
    }

    /**
     * Search users by name, level, or status.
     */
    public function searchUsers(Request $request)
    {
        $query = $request->input('search');
        $users = User::where('username', 'like', "%$query%")
                     ->orWhere('level', 'like', "%$query%")
                     ->orWhere('status', 'like', "%$query%")
                     ->get();

        return view('admin.dashboard', compact('users'));
    }

    /**
     * Show the form for editing a user.
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id); // Find the user by ID
        return view('admin.edit_user', compact('user')); // Pass the user data to the edit view
    }

    /**
     * Update a user's information.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'level' => 'required|integer',
            'points' => 'required|integer',
            'status' => 'required|string|in:active,inactive',
        ]);

        $user->update($validatedData); // Update the user's information

        return redirect()->route('admin.dashboard')->with('success', 'ユーザーが正常に更新されました。');
    }

    /**
     * Delete a user.
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Delete the user

        return redirect()->route('admin.dashboard')->with('success', 'ユーザーが正常に削除されました。');
    }

    /**
     * Display the login penalties settings page.
     */
    public function loginPenalties()
    {
        // You can pass any necessary data here
        return view('admin.login_penalties');
    }

    /**
     * Display the categories settings page.
     */
    public function categories()
    {
        // You can pass any necessary data here
        return view('admin.categories');
    }

    /**
     * Update login penalties settings.
     */
    public function updateLoginPenalties(Request $request)
    {
        $request->validate([
            'inactive_days' => 'required|integer',
            'penalty_level' => 'required|integer',
        ]);

        Config::set('settings.inactive_days', $request->inactive_days);
        Config::set('settings.penalty_level', $request->penalty_level);

        return redirect()->route('admin.login_penalties')->with('success', '設定が正常に更新されました。');
    }

    /**
     * Update category settings.
     */
    public function updateCategories(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        Config::set('settings.category_name', $request->category_name);

        return redirect()->route('admin.categories')->with('success', 'カテゴリが正常に更新されました。');
    }
}