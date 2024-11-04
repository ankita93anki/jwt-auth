<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed'
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password'])
        ]);
        $token = auth('api')->login($user);
        return $this->respondWithToken($token);

        // $token = JWTAuth::fromUser($user);
        // return response()->json(compact('user','token'), 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // if(! $token = Auth()->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        $token = Auth('api')->attempt($credentials);

        if(!$token)
        {
            return response()->json(['error' => 'Unauthorized'], 401);

        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        if (!$user = auth('api')->user()) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }

            return response()->json($user);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
             'access_token' => $token,
             'token_type' => 'bearer',
             'expires_in' => auth('api')->factory()->getTTl() * 60
        ]);
    }
}