<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use TPEx\TPEx\TokenLevel;
use TPEx\TPEx\State;

use function TPEx\TPEx\create_token;

class RegisteredUserController extends Controller
{
    public function create() {
        return view("auth.register");
    }

    public function store() {
        if (request("psk") != env("TPEX_PSK")) {
            throw ValidationException::withMessages(['field_name' => 'Invalid PSK']);
        }
        // Validate
        $validatedAttributes = request()->validate([
            "username" => ["required", "unique:users", "regex:/^[a-zA-Z0-9_]+$/"],
            "password" => ["required", Password::min(5)->letters()->numbers(), "confirmed"]
        ]);

        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), env("TPEX_TOKEN")); // Create connection
        $validatedAttributes["access_token"] = $remote->create_token($validatedAttributes["username"], TokenLevel::ProxyOne);
        // Create User
        $user = User::create(
            array_merge($validatedAttributes, ["admin"=>false])
        );

        // Login
        Auth::login($user);

        // Redirect
        return redirect("/");
    }
}
