<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

       $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return response()->json(['message'=>'Registered','data' => $user], 201);
    }

    public function login(Request $request){
        $request->validate(['email'=>'required|email','password' => 'required']);

        $user = User::where(['email'=>$request->email])->first();
        if(!$user || !Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages(['email'=>['Invalid credentials.']]);
        }
        $token = $user->createToken('api')->plainTextToken;
        return response()->json(['token'=>$token],200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=> 'Logged Out']);
    }

}
