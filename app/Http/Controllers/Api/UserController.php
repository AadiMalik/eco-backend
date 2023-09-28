<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
    public function store(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]
        );
        if ($validation->fails()) {
            $validation_error = "";
            foreach ($validation->errors()->all() as $message) {
                $validation_error .= $message;
            }
            return response()->json(['data' => [], 'message' => $message, 'success' => false], 402);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['data' => $user, 'message' => 'User Added Successfully!', 'success' => true], 200);
    }
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
    public function update(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name??$user->name;
        $user->role = $request-> role ?? $user->role;
        if($request->password!=null && $request->password!=''){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json(['data' => $user, 'message' => 'User Updated Successfully!', 'success' => true], 200);
    }
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['data' => [], 'message' => 'user Deleted Successfully!', 'success' => true], 200);
    }
}
