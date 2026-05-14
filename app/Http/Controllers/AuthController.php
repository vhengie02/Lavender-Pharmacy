<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $credentials['email'])
            ->where('status', 'active')
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $user->update(['last_login' => now()]);

            return redirect()->intended($this->getRedirectPath($user->role));
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'contact_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'customer';
        $validated['status'] = 'active';

        $user = User::create($validated);
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    /**
     * Get redirect path based on user role
     */
    private function getRedirectPath($role)
    {
        return match ($role) {
            'admin' => 'admin.dashboard',
            'editor' => 'editor.products',
            default => 'customer.shop',
        };
    }
}
