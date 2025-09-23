<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function show() {
        $player = request("player");
        if (is_null($player)) {
            $username = Auth::user()->username;
        } else {
            $username = $player;
        }

        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(env("TPEX_FASTSYNC_CACHE")); // Fetch state
        $inventory = $state->player_assets($username);
        $coins = $state->player_balance($username);
        $restricted = $state->restricted_items();

        if (is_null($player)) {
            return view("inventory", ["inventory"=>$inventory, "coins"=>$coins, "restricted"=>$restricted]);
        } else {
            return view("inventory-other", ["inventory"=>$inventory, "coins"=>$coins, "username"=>$username, "restricted"=>$restricted]);
        }
    }

    public function search($player = null) {
        // UPDATE THIS
        $search_term = request("q");

        if (is_null($player)) {
            $username = Auth::user()->username;
        } else {
            $username = $player;
        }

        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(env("TPEX_FASTSYNC_CACHE")); // Fetch state
        $inventory = $state->player_assets($username);
        $coins = $state->player_balance($username);
        $restricted = $state->restricted_items();

        if ($search_term) {
            $search_term = strtolower($search_term);
            $inventory = array_filter(
                $inventory,
                function($item) use ($search_term) { return str_contains(strtolower($item), $search_term); },
                ARRAY_FILTER_USE_KEY
            );
        } else {
            return redirect("/inventory");
        }
        arsort($inventory); // Sort descending

        if (is_null($player)) {
            return view("inventory", ["inventory"=>$inventory, "coins"=>$coins, "restricted"=>$restricted]);
        } else {
            return view("inventory-other", ["inventory"=>$inventory, "coins"=>$coins, "username"=>$username, "restricted"=>$restricted]);
        }
    }
}
