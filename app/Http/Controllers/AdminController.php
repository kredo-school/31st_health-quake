<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the user management page.
     */
    public function users()
    {
        // Mock data for demonstration
        $users = [
            ['name' => 'Fernanda', 'level' => 5, 'points' => 27, 'status' => 'active'],
            ['name' => 'Francisco', 'level' => 6, 'points' => 53, 'status' => 'inactive'],
            ['name' => 'Alberto', 'level' => 7, 'points' => 65, 'status' => 'active'],
            ['name' => 'Mauricio', 'level' => 8, 'points' => 30, 'status' => 'inactive'],
            ['name' => 'Fernando', 'level' => 9, 'points' => 23, 'status' => 'active'],
            ['name' => 'Juan', 'level' => 1, 'points' => 4, 'status' => 'inactive'],
        ];

        return view('admin.users', compact('users'));
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

        return redirect()->route('admin.login_penalties')->with('success', 'Settings updated successfully.');
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

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }
}