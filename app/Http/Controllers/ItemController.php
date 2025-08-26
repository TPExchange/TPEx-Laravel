<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index() {
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(); // Get state
        $orders = $state->raw["order"];
        $buy_orders = $orders["buy_orders"];
        $sell_orders = $orders["sell_orders"];

        return view('items.index', ["buy_orders"=>$buy_orders, "sell_orders"=>$sell_orders]);
    }

    public function buy($game_id) {
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(); // Get state
        $name = ucwords(str_replace("_", " ", $game_id));
        $orders = $state->raw["order"];
        $sell_orders = $orders["buy_orders"];
        $item_orders = $sell_orders[$game_id] ?? [];

        $orders = [];
        foreach ($item_orders as $price => $value) {
            foreach ($value as $order) {
                $order["price"] = $price;
                array_push($orders, $order);
            }
        }


        return view('items.buy-item', ["orders"=>$orders, "name"=>$name]);
    }


    public function sell($game_id) {
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(); // Get state
        $name = ucwords(str_replace("_", " ", $game_id));
        $orders = $state->raw["order"];
        $buy_orders = $orders["buy_orders"];
        $item_orders = $buy_orders[$game_id] ?? [];

        $orders = [];
        foreach ($item_orders as $price => $value) {
            foreach ($value as $order) {
                $order["price"] = $price;
                array_push($orders, $order);
            }
        }


        return view('items.sell-item', ["orders"=>$orders, "name"=>$name]);
    }
}
