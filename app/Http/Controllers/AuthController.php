<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]);
        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }
        $name = $request->input('name');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));

        $register = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        if ($register){
            return response()->json([
                    'success' => true,
                    'message' => 'registrasi sukses',
                    'token' => $register->createToken("API TOKEN")->plainTextToken,
                    'data' => $register
                ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'registrasi gagal',
            ], 400);
        }
    }
    public function login(Request $request)
    {
        $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }
        $email = $request->input('email');
        // $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'email dan password tidak ditemukan',
            ], 403);
        }
        if(!Auth::attempt($request->only(['email', 'password']))){
            return response()->json([
                'success' => false,
                'message' => 'email dan password tidak ditemukan',
            ], 401);
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'accessToken' => $user->createToken("API TOKEN")->plainTextToken,
        ], 200);
    }
}
