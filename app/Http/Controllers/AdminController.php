<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Models\LogAktivitas;
use App\Models\PosterSekolah;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_artikel'   => Artikel::count(),
            'total_users'     => User::count(),
            'total_comments'  => Comment::count(),
            'pending_artikel' => Artikel::where('status', 'pending')->count(),
        ];

        $recent_articles = Artikel::with(['user', 'kategori'])->latest()->limit(10)->get();
        $recent_logs     = LogAktivitas::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recent_articles', 'recent_logs'));
    }

    public function comments()
    {
        $comments = Comment::with(['user', 'artikel'])->latest()->paginate(20);
        return view('admin.comments', compact('comments'));
    }

    public function likes()
    {
        $likes = Like::with(['user'])->latest()->paginate(20);
        return view('admin.likes', compact('likes'));
    }

    public function reports()
    {
        $stats = [
            'total_artikel'    => Artikel::count(),
            'total_published'  => Artikel::where('status', 'published')->count(),
            'total_users'      => User::count(),
            'total_comments'   => Comment::count(),
        ];
        $artikel = Artikel::with(['user', 'kategori'])->latest()->get();
        return view('admin.reports', compact('stats', 'artikel'));
    }

    public function posterIndex()
    {
        $posters = PosterSekolah::with('user')->latest()->paginate(12);
        return view('admin.poster.index', compact('posters'));
    }

    public function posterPublish($id)
    {
        $poster = PosterSekolah::findOrFail($id);
        $poster->update(['status' => 'published']);
        return back()->with('success', 'Poster berhasil dipublish!');
    }
}
