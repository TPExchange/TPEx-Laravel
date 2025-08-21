<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index() {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return view("admin.transactions.index");
        } else {
            abort("403");
        }
    }

    public function show($id) {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return view("admin.transactions.show", ["id"=>$id]);
        } else {
            abort("403");
        }
    }
}
