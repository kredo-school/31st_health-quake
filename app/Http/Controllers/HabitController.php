<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Habit;

class HabitController extends Controller
{
    /**
     * Delete the authenticated user's habit
     */
    public function destroy($id)
    {
        // Get the authenticated user's ID
        $user = Auth::id();

        // Search for the corresponding habit
        $habit = Habit::where('id', $id)
            ->where('user_id', $user)
            ->first();

        if (!$habit) {
            // Return error message if habit not found or unauthorized
            return redirect()->route('set-routine')
                ->with('error', 'Habit not found or you do not have permission to delete this habit');
        }

        // Delete the habit
        $habit->delete();

        // Redirect with success message
        return redirect()->route('set-routine')
            ->with('success', 'Habit has been deleted');
    }

    /**
     * Display the latest 4 habits
     */
    public function index()
    {
        // Retrieve latest 4 habits for the authenticated user
        $habits = Auth::user()->habits()
            ->latest()
            ->take(4)
            ->get();

        // Pass habits to the view
        return view('routines.SetRoutine', compact('habits'));
    }

    /**
     * Save a new habit
     */
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // Check habit count before saving
        $currentHabitsCount = Auth::user()->habits()->count();

        if ($currentHabitsCount >= 3) {
            return redirect()->back()
                ->withErrors(['error' => 'You can only set up to 3 habits.'])
                ->withInput();
        }

        // Assign user_id and save
        $validatedData['user_id'] = Auth::id();
        Habit::create($validatedData);

        // Redirect with success message
        return redirect()->route('set-routine')
            ->with('success', 'Habit has been saved successfully.');
    }
}