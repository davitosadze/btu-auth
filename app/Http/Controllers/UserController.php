<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login() {
        return view("user.login");
    }

    public function registration() {
        return view("user.registration");
    }

    public function profile() {
        return view("user.profile");
    }
}
