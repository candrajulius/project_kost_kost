<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function login(Request $request)
    {

        $message_error = [
            'name.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ];
        // Validate the request data
        $credential = $request->validate([
            'name' => 'required',
            'password' => 'required|string',
        ],$message_error);


        $throttleKey = 'login:' . $request->ip();

        // Throttle sederhana untuk login
        if (RateLimiter::tooManyAttempts('login', 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return response()->json([
                'message' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . $seconds . ' detik.'
            ], 429);
        }

        if (!Auth::attempt(['name' => $credential['name'], 'password' => $credential['password']])) {
            RateLimiter::hit($throttleKey);
            return response()->json([
                'message' => 'Login gagal. Periksa kembali username dan password Anda.'
            ], 401);
        }

        RateLimiter::clear($throttleKey);
        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        $message_error = [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ];

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:pemilik,penyewa',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
        ], $message_error);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'],
            'address' => $data['address'],
        ]);

        $user->assignRole($data['role']);

        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user,
            'role' => $data['role'],
        ],201);
    }
}
