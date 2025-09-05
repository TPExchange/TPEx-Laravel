<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BuyOrderController extends Controller
{
    public function create($item = null) {
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(); // Fetch state
        $restricted = $state->restricted_items();
        $items = explode("\n", file_get_contents("../database/items.txt"));

        if (is_null($item)) {
            // Return without specific item
            return view("items.buy-order-form", ["items"=>$items, "restricted"=>$restricted]);
        } else {
            // Return with specific item
            return view("items.buy-order-form", ["items"=>$items, "item"=>$item, "restricted"=>$restricted]);
        }
    }


    public function store() {
        $item = request("item");
        $quantity = request("quantity");
        $price = request("price");
        $items = explode("\n", file_get_contents("../database/items.txt"));

        if (!in_array($item, $items)) {
            throw ValidationException::withMessages(['field_name' => 'Invalid item name. Try selecting from the drop-down box.']);
        }

        try {
            $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
            $remote->apply("BuyOrder", [
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
