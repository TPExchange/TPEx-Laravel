<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use TPEx\TPEx\TokenLevel;
use TPEx\TPEx\Remote;

use function TPEx\TPEx\create_token;

class SessionController extends Controller
{
    public function create()
    {
        return view("auth.login");
    }

    public function store()
    {
        // Validate
        $validatedAttributes = request()->validate([
            "username" => ["required"],
            "password" => ["required"]
        ]);

        // Attempt to log in
        if (! Auth::attempt($validatedAttributes))
        {
            throw ValidationException::withMessages([
                "password" => "Incorrect login details"
            ]);
        }

        // Regenerate session token
        request()->session()->regenerate();

        // Generate Access Token If Missing
        if(is_null(Auth::user()->access_token)) {
            $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), env("TPEX_TOKEN")); // Create connection
            $token = $remote->create_token($validatedAttributes["username"], TokenLevel::ProxyOne);
            Auth::user()->update(["access_token"=>$token]);
        }

        // Update Admin Status On Login
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync();
        $bankers = $state->bankers();

        $isAdmin = in_array(Auth::user()->username, $bankers);
        Auth::user()->update(["admin"=>$isAdmin]);

        // Redirect
        return redirect("/");
    }

    public function destroy()
    {
        // Log user out
        Auth::logout();

        // Redirect
        return redirect("/");
    }
}
