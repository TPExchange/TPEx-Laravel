<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function show($player = null) {
        if (is_null($player)) {
            $username = Auth::user()->username;
        } else {
            $username = $player;
        }
        
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(); // Fetch state
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
        $state = $remote->fastsync(); // Fetch state
        $inventory = $state->player_assets($username);
        $coins = $state->player_balance($username);

        if ($search_term) {
            $inventory = $this->search($inventory, $search_term);
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
