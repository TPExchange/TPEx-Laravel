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
    $username = strtolower(Auth::user()->username);
    $remote = new TPEx\TPEx\Remote(env("TPEX_URL"), Auth::user()->access_token); // Create connection
    $state = $remote->fastsync(); // Fetch state
    $inventory = $state->player_assets($username);
    $coins = $state->player_balance($username);
    return view("inventory", ["inventory"=>$inventory, "coins"=>$coins]);
})->middleware("auth");

Route::get("/inventory/search", [SearchController::class, "inventory"])->middleware("auth");


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
        $resetUser = User::find(request("user"));
        $newPassword = request("new_password");
        $resetUser->update(["password"=>$newPassword]);
        return view("admin.reset-password-success", ["new_password"=>$newPassword, "reset_user"=>$resetUser]);
    } else {
        abort("403");
    }
})->middleware("auth");

// Withdrawals
Route::get("/admin/deposits-withdrawals", function () {
    $user = Auth::user();
    if ($user->isAdmin()) {
        return view("admin.deposits_withdrawals");
    } else {
        abort("403");
    }
})->middleware("auth");
