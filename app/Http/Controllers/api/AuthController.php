<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    function register(Request $request)
    {
        $vdata = $request->validate([
            'name' => 'required',
            'email' => 'email|unique:users,email|required',
            'password' => 'required|confirmed'

        ]);

        $vdata['password'] = bcrypt($vdata['password']);

        User::create($vdata);

        return $this->login($request);
    }

    public function login(Request $request)
    {

        $vdata = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $user = User::firstWhere('email', $vdata['email']);

        if ($user && Hash::check($vdata['password'], $user->password)) {
            $token = $user->createToken($request->userAgent());
            $user->token = $token->plainTextToken;
            return response()->json($user);
        } else {
            return response()->json(['message' => 'Unauthenticated.']);
        }
    }
}
