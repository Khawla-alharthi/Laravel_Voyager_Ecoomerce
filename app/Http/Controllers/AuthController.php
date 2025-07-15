<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // show login -> return login view
    public function showLoginForm() {
        return view('auth.login');
    }

    // post -> Handle login request form submission
    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($validated))
        {
            // regenerate the session id for a new authenticated user
            // provide more secure environment for the user
            $request->session()->regenerate();
            return redirect()->route('base');
        }

        throw ValidationException::withMessages([
            'credentials' => 'Sorry, incorrect credentials',
        ]);
    }

    // show register -> return register view
    public function showRegisterForm() {
        return view('auth.register');
    }

    // post -> Handle register request form submission
    public function register(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:10|confirmed'
        ]);
  
        // Hash the password before saving
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        Auth::login($user); // sugested
        return redirect()->route('base')->with('success', 'Your account has been created successfully!');;
    }

    // logout the user
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        // Regenerate the CSRF token for security
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been logged out.');
    }

}
