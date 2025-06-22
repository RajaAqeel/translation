<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $req)
    {
        $user = \App\Models\User::find(1);
        $token = $user->createToken('dev-token')->plainTextToken;
        return response()->json($token);
    }
}
