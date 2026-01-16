<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login API user
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'Akun tidak aktif'], 403);
        }

        // Generate token
        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }


    /**
     * Ambil data user yang login
     */
    public function me(Request $request)
{
    $user = $request->user()->load('shift');

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'instansi' => $user->instansi, // null jika tidak ada
        'status' => $user->status,
        'mode_kerja' => $user->mode_kerja,
        'shift' => $user->shift ? [
            'nama_shift' => $user->shift->nama_shift,
            'mulai' => $user->shift->mulai,
            'selesai' => $user->shift->selesai,
        ] : null,
    ]);
}


    /**
     * Logout API user
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout berhasil']);
    }
}
