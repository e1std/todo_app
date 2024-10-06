<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegiseredUserController extends Controller
{
    function create()
    {
        return view('auth.register');
    }

    function store()
    {
        // validate the request

        $validatedAttributes = request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ]);
        User::create($validatedAttributes);

        return redirect('/');
    }


}
