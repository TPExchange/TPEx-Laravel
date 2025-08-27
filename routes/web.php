<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SearchController;
use \App\Http\Controllers\SessionController;
use App\Http\Controllers\TransactionController;
use App\Models\InventoryItem;
use App\Models\Item;
use App\Models\SellOrder;
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

Route::get('/items', [ItemController::class, "index"])->middleware("auth");
Route::get("/items/search", [SearchController::class, "items"])->middleware("auth");
Route::get("/items/{game_id}/buy", [ItemController::class, "buy"])->middleware("auth");
Route::get("/items/{game_id}/sell", [ItemController::class, "sell"])->middleware("auth");

Route::get("/inventory", function () {
    $username = Auth::user()->username;
    $remote = new \TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
    $state = $remote->fastsync(); // Fetch state
    $inventory = $state->player_assets($username);
    $coins = $state->player_balance($username);
    return view("inventory", ["inventory"=>$inventory, "coins"=>$coins]);
})->middleware("auth");

Route::get("/inventory/search", [SearchController::class, "inventory"])->middleware("auth");

// Withdraw
Route::get("/withdraw", function () {
    $items = explode("\n", file_get_contents("../database/items.txt"));
    return view("withdraw", ["items"=>$items]);
})->middleware("auth");

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
    } catch (Exception $e) {
        throw ValidationException::withMessages(['field_name' => $e->getMessage()]);
    }

    $items = explode("\n", file_get_contents("../database/items.txt"));
    return view("withdraw", ["success"=>1,"items"=>$items]);

})->middleware("auth");

// ========== //
//   Orders   //
// ========== //

Route::get("/orders", function() {
    return view("orders.index");
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

// Admin Transactions
Route::get("/admin/transactions", [TransactionController::class, "index"])->middleware("auth");
Route::get("/admin/transactions/{id}", [TransactionController::class, "show"])->middleware("auth");

// Password Reset
Route::get("/admin/manage-users", function () {
    $user = Auth::user();
    if ($user->isAdmin()) {
        return view("admin.reset-password");
    } else {
        abort("403");
    }
})->middleware("auth");

Route::post("/admin/manage-users", function () {
    $user = Auth::user();
    if ($user->isAdmin()) {
        if (request("user")) {
            $resetUser = User::find(request("user"));
            $newPassword = request("new_password");
            $resetUser->update(["password"=>$newPassword]);
            return view("admin.reset-password-success", ["new_password"=>$newPassword, "reset_user"=>$resetUser]);
        } else {
            return view("admin.reset-password");
        }
    } else {
        abort("403");
    }
})->middleware("auth");

// Deposits/Withdrawals
Route::get("/admin/deposits-withdrawals", function () {
    $user = Auth::user();
    if ($user->isAdmin()) {
        return view("admin.deposits_withdrawals");
    } else {
        abort("403");
    }
})->middleware("auth");


// Deposits Form

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

// Withdrawals

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