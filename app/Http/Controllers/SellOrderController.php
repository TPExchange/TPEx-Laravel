<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SellOrderController extends Controller
{
    public function create($item) {
        if ($item == "diamond") {
            return redirect("/exchange-coins?mode=sell");
        }
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(); // Get state
        $name = ucwords(str_replace("_", " ", $item));
        $orders = $state->raw["order"];
        $buy_orders = $orders["buy_orders"];
        $item_orders = $buy_orders[$item] ?? [];
        $restricted = $state->restricted_items();

        $orders = [];
        foreach ($item_orders as $price => $value) {
            foreach ($value as $order) {
                $order["price"] = $price;
                array_push($orders, $order);
            }
        }

        $items = explode("\n", file_get_contents("../database/items.txt"));

        return view('items.sell-item', ["orders"=>$orders, "name"=>$name, "item"=>$item, "restricted"=>$restricted, "items"=>$items]);
    }

    public function store() {
        $item = request("item");
        $quantity = request("quantity");
        $price = request("price");

        try {
            $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
            $remote->apply("SellOrder", [
                "player"=>Auth::user()->username,
                "asset"=>$item,
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
