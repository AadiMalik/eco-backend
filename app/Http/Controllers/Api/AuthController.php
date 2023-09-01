<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['data'=>$user,'message' => 'User Register Successfully!', 'success' => true], 200);
    }

    public function login(Request $request)
    {
        $credentials = ['email' => $request->email, 'password' => $request->password];
        $user = Auth::attempt($credentials);
        if (isset($user)) {
            return response()->json(['data'=>$user,'message' => 'User Register Successfully!', 'success' => true], 200);
        }
    }
}
