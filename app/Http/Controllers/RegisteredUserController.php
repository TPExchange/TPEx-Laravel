<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use tpex\tpex\TokenLevel;
use tpex\tpex\State;

use function tpex\tpex\create_token;

class RegisteredUserController extends Controller
{
    public function create() {
        return view("auth.register");
    }

    public function store() {
        // Validate
        $validatedAttributes = request()->validate([
            "username" => ["required", "unique:users"],
            "password" => ["required", Password::min(5)->letters()->numbers(), "confirmed"]
        ]);

        $remote = new \TPEx\TPEx\Remote("https://tpex-staging.cyclic3.dev", "3H/xEZPV2FTRHrWtkUpIKA"); // Create connection
        $validatedAttributes["access_token"] = $remote->create_token($validatedAttributes["username"], TokenLevel::ProxyOne);
        // Create User
        $user = User::create(
            $validatedAttributes
        );

        // Login
        Auth::login($user);

        // Redirect
        return redirect("/");
    }
}
