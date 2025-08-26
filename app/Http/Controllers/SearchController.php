<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tpex\Tpex\State;

class SearchController extends Controller
{
    function search($array, $search_term) {
        $search_results = [];
        $search_term = strtolower($search_term);
        foreach (array_keys($array) as $item) {
            if (str_contains(strtolower($item), $search_term))
            {
                $search_results[$item] = $array[$item];
            }
        }
        return $search_results;
    }   

    public function items() {
        // UPDATE THIS
        $search_term = request("q");
        $remote = new \TPEx\TPEx\Remote("https://tpex-staging.cyclic3.dev", Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(); // Get state
        
        $orders = $state["order"];
        $buy_orders = $orders["buy_orders"];
        $sell_orders = $orders["sell_orders"];




        if ($search_term) {
            $buy_orders = $this->search($buy_orders, $search_term);
            $sell_orders = $this->search($sell_orders, $search_term);
        } else {
            return redirect("/items");
        }


        return view("items.index", ["search" => $search_term,"buy_orders" => $buy_orders, "sell_orders" => $sell_orders]);
    }

    public function inventory() {
        // UPDATE THIS
        $search_term = request("q");
        $username = Auth::user()->username;
        $remote = new \TPEx\TPEx\Remote("https://tpex-staging.cyclic3.dev", Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(); // Fetch state
        $inventory = $state->player_assets($username);
        $coins = $state->player_balance($username);

        if ($search_term) {
            $inventory = $this->search($inventory, $search_term);
        } else {
            return redirect("/inventory");
        }
        arsort($inventory); // Sort descending
        return view("inventory", ["inventory"=>$inventory, "coins"=>$coins]);
    }
}
