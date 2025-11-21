<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showResetForm($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.reset-password', compact('user'));
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::findOrFail($id);
        
        $user->update([
            'password' => Hash::make($request->new_password),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Password user ' . $user->username . ' berhasil direset');
    }

    public function generateRandomPassword($id)
    {
        $user = User::findOrFail($id);
        $newPassword = Str::random(10);
        
        $user->update([
            'password' => Hash::make($newPassword),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Password user ' . $user->username . ' berhasil direset ke: ' . $newPassword . ' (Catat password ini!)');
    }
}