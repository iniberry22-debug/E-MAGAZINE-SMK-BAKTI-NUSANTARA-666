<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Artikel;
use Illuminate\Support\Facades\Auth;

class GuruKomentarController extends Controller
{
    public function index()
    {
        // Ambil semua komentar dengan pagination
        $comments = \DB::table('comments')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.Guru.komentar.index', compact('comments'));
    }
    
    public function artikel($id)
    {
        $user = Auth::user();
        $artikel = Artikel::where('id_artikel', $id)
            ->where(function($q) use ($user) {
                $q->where('id_user', $user->id_user)
                  ->orWhere(function($subq) {
                      $subq->whereHas('user', function($userq) {
                          $userq->where('role', 'siswa');
                      })->whereIn('status', ['approved', 'published']);
                  });
            })
            ->with(['comments.user', 'user'])
            ->firstOrFail();
            
        return view('admin.Guru.komentar.artikel', compact('artikel'));
    }
}