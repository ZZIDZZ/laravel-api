<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
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
        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'email tidak ditemukan',
            ], 403);
        }
        if (Hash::check($password, $user->password)){
            $apiToken = base64_encode(Str::random(40));
            $user->update([
                'api_token' => $apiToken
            ]);
            return response()->json([
                'success' => true,
                'message' => 'login sukses',
                'data' => [
                    'user' => $user,
                    'api_token' => $apiToken
                ]
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'login gagal',
                'data' => ''
            ], 401);
        }
    }
}
