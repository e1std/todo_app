<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    // Show the login form
    function create()
    {
        return view('auth.login');
    }

    // Handle the login request
    function store(Request $request)
    {
        // Validate the login credentials
        $credentials = $this->validateLogin($request);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent fixation attacks
            request()->session()->regenerate();

            // Redirect to the homepage on successful login
            return redirect('/');
        }

        // Redirect back with an error message if authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle the logout request
    function destroy()
    {
        // Log the user out
        Auth::logout();

        // Redirect to the homepage after logout
        return redirect('/');
    }

    // Validate the login credentials
    protected function validateLogin(Request $request)
    {
        return $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    }
}
