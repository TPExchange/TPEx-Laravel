<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuyOrderController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SellOrderController;
use \App\Http\Controllers\SessionController;
use App\Http\Controllers\TransactionController;
use App\Models\BuyOrder;
use App\Models\User;
use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use TPEx\TPEx\State;

use function TPEx\TPEx\format_millicoins;
use function TPEx\TPEx\parse_millicoins;

Route::get('/', function () {
    return view('welcome');
});


// ========= //
//   Items   //
// ========= //

// Display all items listed
Route::get('/items', function () {
    $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
    $state = $remote->fastsync(); // Get state
    $buy_orders = $state->buy_orders();
    $sell_orders = $state->sell_orders();
    $restricted = $state->restricted_items();

    return view('items.index', ["buy_orders"=>$buy_orders, "sell_orders"=>$sell_orders, "restricted"=>$restricted]);
})->middleware("auth");

// Search all items listed
Route::get("/items/search", function () {
    // UPDATE THIS
    $search_term = request("q");
    $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
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
})->middleware("auth");



// ============== //
//   Buy Orders   //
// ============== //

// Buy orders form
Route::get("/items/buy", [BuyOrderController::class, "create"])->middleware("auth");

// Buy orders form with specific item
Route::get("/items/{game_id}/buy", [BuyOrderController::class, "create"])->middleware("auth");

// Buy order submission/execution
Route::post("/items/buy", [BuyOrderController::class, "store"])->middleware("auth");





// =============== //
//   Sell Orders   //
// =============== //

// Sell order form with specific item
Route::get("/items/{game_id}/sell", [SellOrderController::class, "create"])->middleware("auth");

// Sell order submission/execution
Route::post("/items/{game_id}/sell", [SellOrderController::class, "store"])->middleware("auth");



// ============= //
//   Inventory   //
// ============= //

// Display inventory
Route::get("/inventory", [InventoryController::class, "show"])->middleware("auth");
// Display other inventory
Route::get("/inventory/{player}", [InventoryController::class, "show"])->middleware("auth");

// Search inventory
Route::get("/inventory/search", [InventoryController::class, "search"])->middleware("auth");
// Search other inventory - TODO
Route::get("/inventory/{player}/search", [InventoryController::class, "search"])->middleware("auth");




// =============== //
//   Withdrawals   //
// =============== //

// Withdraw form
Route::get("/withdraw", function () {
    $items = explode("\n", file_get_contents("../database/items.txt"));
    return view("withdraw", ["items"=>$items]);
})->middleware("auth");

// Withdraw submission
Route::post("/withdraw", function () {
    $items = request("items");
    $counts = request("counts");
    $assets = [];
    for ($i = 0; $i < count($items); $i++) {
        isset($assets[$items[$i]]) ? $assets[$items[$i]] += (int)$counts[$i] : $assets[$items[$i]] = (int)$counts[$i];
    }

    try {
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $remote->apply("RequestWithdrawal", [
            "player"=>Auth::user()->username,
            "assets"=>$assets
        ]);
    } catch (\TPEx\TPEx\Error $e) {
        $tpexError = json_decode($e->tpex_error)->error;
        throw ValidationException::withMessages(['field_name' => $tpexError]);
    }

    $items = explode("\n", file_get_contents("../database/items.txt"));
    return view("withdraw", ["success"=>1,"items"=>$items]);

})->middleware("auth");


// ========= //
//   Coins   //
// ========= //

// Coin exchange form
Route::get("/exchange-coins", function () {
    $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
    $state = $remote->fastsync(); // Fetch state
    $rates = $state->rates();
    $sellRate = $rates["coins_sell_ppm"]/10000; // As percentage
    $buyRate = $rates["coins_buy_ppm"]/10000; // As percentage

    return view("coins-conversion", ["buyRate"=>$buyRate, "sellRate"=>$sellRate]);
})->middleware("auth");

// Coin exchange submission
Route::post("/exchange-coins", function() {
    try {
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $state = $remote->fastsync(); // Fetch state
        $rates = $state->rates();
        $sellRate = $rates["coins_sell_ppm"]/1000000; // As multiplier
        $buyRate = $rates["coins_buy_ppm"]/1000000; // As multiplier

        $params = request()->all();
        if ($params["direction"] == "diamondsToCoins") {
            $diamonds = $params["diamonds"];
            $remote->apply("BuyCoins", [
                "player"=>Auth::user()->username,
                "n_diamonds"=>(int)$diamonds
            ]);
        } else {
            $diamonds = $params["diamonds"];
            $remote->apply("SellCoins", [
                "player"=>Auth::user()->username,
                "n_diamonds"=>(int)$diamonds
            ]);
        }
    } catch (\TPEx\TPEx\Error $e) {
        $tpexError = json_decode($e->tpex_error)->error;
        throw ValidationException::withMessages(['field_name' => $tpexError]);
    }

    // Convert back to percentages
    $buyRate = $buyRate * 100;
    $sellRate = $sellRate * 100;

    return view("coins-conversion", ["buyRate"=>$buyRate, "sellRate"=>$sellRate, "success"=>1]);
})->middleware("auth");



// =============== //
//   User Orders   //
// =============== //

// User orders list
Route::get("/orders", function() {
    $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
    $state = $remote->fastsync(); // Get state
    $user = Auth::user()->username;
    $buy_orders = $state->buy_orders($user);
    $sell_orders = $state->sell_orders($user);
    $restricted = $state->restricted_items();

    return view("orders.index", ["buy_orders"=>$buy_orders, "sell_orders"=>$sell_orders, "restricted"=>$restricted]);
})->middleware("auth");

// User orders cancel
Route::post("/orders/cancel/{id}", function ($id) {
    try {
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $remote->apply("CancelOrder", [
            "target"=>(int)$id
        ]);
    } catch (Exception $e) {
        throw ValidationException::withMessages(['field_name' => $e->getMessage()]);
    }

    return redirect("/orders");
})->middleware("auth");



// ======== //
//   Auth   //
// ======== //

// Register
Route::get("/register", [RegisteredUserController::class, "create"])->middleware("guest");
Route::post("/register", [RegisteredUserController::class, "store"])->middleware("guest");

// Login
Route::get("/login", [SessionController::class, "create"])->name("login")->middleware("guest");
Route::post("/login", [SessionController::class, "store"])->middleware("guest");
Route::post("/logout", [SessionController::class, "destroy"])->middleware("auth");

// Admin Control Panel
Route::get("/admin", function () {
    $user = Auth::user();
    if ($user->isAdmin()) {
        return view("admin.control-panel");
    } else {
        abort("403");
    }
})->middleware("auth");


// ========= //
//   Admin   //
// ========= //

// Transaction log
Route::get("/admin/transactions", [TransactionController::class, "index"])->middleware("auth");
Route::get("/admin/transactions/{id}", [TransactionController::class, "show"])->middleware("auth");

// Password reset form
Route::get("/admin/manage-users", [AdminController::class, "passwordFormGet"])->middleware("auth");

// Password reset submission
Route::post("/admin/manage-users", [AdminController::class, "passwordFormPost"])->middleware("auth");

// Deposits/Withdrawals
Route::get("/admin/deposits-withdrawals", function () {
    $user = Auth::user();
    if ($user->isAdmin()) {
        return view("admin.deposits_withdrawals");
    } else {
        abort("403");
    }
})->middleware("auth");


// ============ //
//   Deposits   //
// ============ //

// Deposit form
Route::get("/admin/deposits", function () {
    $user = Auth::user();
    if($user->isAdmin()) {
        $players = User::all();
        $items = explode("\n", file_get_contents("../database/items.txt"));
        return view("admin.deposits", ["players"=>$players,"items"=>$items]);
    } else {
        abort("403");
    }
})->middleware("auth");

// Deposit submission
Route::post("/admin/deposits", function () {
    $user = Auth::user();
    if($user->isAdmin()) {
        $players = DB::table('users')->pluck('username')->toArray();
        $items = explode("\n", file_get_contents("../database/items.txt"));

        // Extract request data
        $player = request("player");
        $item = request("item");
        $quantity = request("quantity");
        $quantityConfirm = request("quantityConfirm");
        $banker = $user->username;

        if (!(in_array($player, $players) && in_array($item, $items) && ($quantity == $quantityConfirm))) {
            throw ValidationException::withMessages(['field_name' => 'Invalid deposit']);
        }

        try {
            $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
            $remote->apply("Deposit", [
                "player"=>$player,
                "asset"=>$item,
                "count"=>(int)$quantity,
                "banker"=>$banker
            ]);
        } catch (Exception $e) {
            throw ValidationException::withMessages(['field_name' => $e->getMessage()]);
        }

        $players = User::all();
        $items = explode("\n", file_get_contents("../database/items.txt"));
        return view("admin.deposits", ["success"=>1, "players"=>$players, "items"=>$items]);
    } else {
        abort("403");
    }
})->middleware("auth");


// =============== //
//   Withdrawals   //
// =============== //

// Withdrawals list
Route::get("/admin/withdrawals", function () {
    $user = Auth::user();

    $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
    $state = $remote->fastsync();
    $withdrawals = $state->pending_withdrawals();
    if ($user->isAdmin()) {
        return view("admin/withdrawals", ["withdrawals"=>$withdrawals]);
    } else {
        abort("403");
    }
})->middleware("auth");

// Withdrawal show
Route::get("/admin/withdrawals/{id}", function ($id) {
    $user = Auth::user();

    $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
    $state = $remote->fastsync();
    $withdrawals = $state->pending_withdrawals();
    if ($user->isAdmin()) {
        return view("admin/withdrawal-show", ["withdrawal"=>$withdrawals[$id],"id"=>$id]);
    } else {
        abort("403");
    }
})->middleware("auth");

// Withdrawal complete submission
Route::post("/admin/complete-withdrawal", function () {
    $user = Auth::user();

    $id = request("withdrawal_id");
    if ($user->isAdmin()) {
        $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
        $remote->apply("CompleteWithdrawal", [
            "target"=>(int)$id,
            "banker"=>$user->username
        ]);
        return redirect("/admin/withdrawals");
    } else {
        abort("403");
    }
})->middleware("auth");
