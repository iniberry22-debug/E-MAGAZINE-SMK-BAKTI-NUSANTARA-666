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

        $stats = [
            'my_articles'      => Artikel::where('id_user', $user->id_user)->count(),
            'published'        => Artikel::where('id_user', $user->id_user)->where('status', 'published')->count(),
            'draft'            => Artikel::where('id_user', $user->id_user)->where('status', 'draft')->count(),
            'student_pending'  => Artikel::whereHas('user', fn($q) => $q->where('role', 'siswa'))->where('status', 'pending')->count(),
            'published_posters'=> PosterSekolah::where('status', 'published')->count(),
        ];

        $recent_articles = Artikel::where(function($q) use ($user) {
                $q->where('id_user', $user->id_user)
                  ->orWhere(function($q2) {
                      $q2->whereHas('user', fn($q3) => $q3->where('role', 'siswa'))
                         ->whereIn('status', ['approved', 'published']);
                  });
            })
            ->with(['kategori', 'comments', 'user'])
            ->latest('tanggal')
            ->paginate(10, ['*'], 'recent');

        $student_articles = Artikel::whereHas('user', fn($q) => $q->where('role', 'siswa'))
            ->where('status', 'pending')
            ->with('user')
            ->latest('tanggal')
            ->paginate(5, ['*'], 'pending');

        $published_posters = PosterSekolah::with('user')
            ->where('status', 'published')
            ->latest()
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

        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aksi'    => 'Mempublish poster: ' . $poster->judul,
        ]);

        return back()->with('success', 'Poster berhasil dipublish!');
    }
}
