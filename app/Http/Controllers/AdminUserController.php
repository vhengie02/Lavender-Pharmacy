<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display list of all users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->has('search') && $request->search) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('email', 'like', $search)
                  ->orWhere('contact_number', 'like', $search);
            });
        }

        $users = $query->latest('date_created')->paginate(15);

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show user details
     */
    public function show(User $user)
    {
        $user->load('orders');
        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show edit user form
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'role' => 'required|in:customer,editor,admin',
            'status' => 'required|in:active,inactive,banned',
            'contact_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
        ]);

        if ($request->password) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully');
    }

    /**
     * Delete a user
     */
    public function destroy(User $user)
    {
        if ($user->user_id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
