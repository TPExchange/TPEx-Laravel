<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    public function index() {
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(); // Get state
        $buy_orders = $state->buy_orders();
        $sell_orders = $state->sell_orders();

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


        return view('items.sell-item', ["orders"=>$orders, "name"=>$name, "item"=>$game_id]);
    }

    public function sellPost($game_id) {
        $quantity = request("quantity");
        $price = request("price");

        

        try {
            $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
            $remote->apply("SellOrder", [
                "player"=>Auth::user()->username,
                "asset"=>$game_id,
                "count"=>(int)$quantity,
                "coins_per"=>$price
            ]);

        } catch (\TPEx\TPEx\Error $e) {
            $tpexError = json_decode($e->tpex_error)->error;
            throw ValidationException::withMessages(['field_name' => $tpexError]);
        }

        return redirect("/inventory");
    }
}
