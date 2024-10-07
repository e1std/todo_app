<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegiseredUserController extends Controller
{
    // Show the registration form
    function create()
    {
        return view('auth.register');
    }

    // Handle the registration request
    function store(Request $request)
    {
        // validate the request

        $validatedAttributes = $this->validateRequest($request);
        User::create($validatedAttributes);

        return redirect('/');
    }

    // Validate the registration request
    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ]);
    }
}
