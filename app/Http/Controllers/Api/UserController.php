<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{
    public function register(Request $req) {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $req->name,
            'password' => Hash::make($req->password),
            'email' => $req->email
        ]);

        $token = $user->createToken('Tokens')->plainTextToken;
        return response()->json(["token" => $token, "user" => $user]);

    }

    public function login(Request $req) {
        $validator = Validator::make($req->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        if(!Auth::attempt($req->all())) {
            return response()->json(["error" => "Incorrect login or password"], 403);
        }

        $user = auth()->user();
        $token = $user->createToken('Tokens')->plainTextToken;
        return response()->json(["token" => $token, "user" => $user], 200);

    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return response()->json(["success" => "Successfully logged out"], 200);
    }

    public function profile() {
        return auth()->user();
    }
}
