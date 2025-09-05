<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function passwordFormGet() {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return view("admin.reset-password");
        } else {
            abort("403");
        }
    }

    public function passwordFormPost() {
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
    }
}
