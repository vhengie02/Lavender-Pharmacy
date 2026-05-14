<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show user profile
     */
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    /**
     * Show profile edit form
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id() . ',user_id',
            'contact_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
        ]);

        if ($request->password) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        Auth::user()->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }
}
