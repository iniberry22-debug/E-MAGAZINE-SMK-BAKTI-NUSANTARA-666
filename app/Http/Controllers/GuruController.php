<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\PosterSekolah;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get statistics for current teacher
        $stats = [
            'my_articles' => Artikel::where('id_user', $user->id_user)->count(),
            'published' => Artikel::where('id_user', $user->id_user)->where('status', 'published')->count(),
            'draft' => Artikel::where('id_user', $user->id_user)->where('status', 'draft')->count(),
            'student_pending' => Artikel::whereHas('user', function($query) {
                $query->where('role', 'siswa');
            })->where('status', 'pending')->count(),
            'published_posters' => PosterSekolah::where('status', 'published')->count()
        ];
        
        // Get recent articles from teacher and approved student articles
        $recent_articles = Artikel::where(function($query) use ($user) {
                $query->where('id_user', $user->id_user)
                      ->orWhere(function($q) {
                          $q->whereHas('user', function($subq) {
                              $subq->where('role', 'siswa');
                          })->whereIn('status', ['approved', 'published']);
                      });
            })
            ->with(['kategori', 'comments', 'user'])
            ->latest('tanggal')
            ->paginate(10, ['*'], 'recent');
            
        // Get student articles pending approval
        $student_articles = Artikel::whereHas('user', function($query) {
                $query->where('role', 'siswa');
            })
            ->where('status', 'pending')
            ->with('user')
            ->latest('tanggal')
            ->paginate(5, ['*'], 'pending');
        
        // Get published posters with pagination
        $published_posters = PosterSekolah::with('user')
            ->where('status', 'published')
            ->latest('created_at')
            ->paginate(6, ['*'], 'posters');
        
        return view('admin.Guru.dashboard', compact('stats', 'recent_articles', 'student_articles', 'published_posters'));
    }
    
    public function posterIndex()
    {
        $posters = PosterSekolah::with('user')->where('status', 'pending')->latest()->paginate(12);
        return view('admin.Guru.poster.index', compact('posters'));
    }
    
    public function posterApprove($id)
    {
        $poster = PosterSekolah::findOrFail($id);
        $poster->update(['status' => 'published']);
        
        // Log aktivitas
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'aksi' => 'Mempublish poster: ' . $poster->judul
        ]);
        
        return back()->with('success', 'Poster berhasil dipublish!');
    }
}