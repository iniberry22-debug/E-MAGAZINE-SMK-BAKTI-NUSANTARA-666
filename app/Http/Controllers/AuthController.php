<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();
        
        // Cek password dengan hash
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            
            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('home')->with('success', 'Login berhasil sebagai admin');
                case 'guru':
                    return redirect()->route('home')->with('success', 'Login berhasil sebagai guru');
                case 'siswa':
                    return redirect()->route('home')->with('success', 'Login berhasil sebagai siswa');
                default:
                    return redirect()->route('home');
            }
        }

        return back()->withErrors(['username' => 'Username atau password salah']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }


}