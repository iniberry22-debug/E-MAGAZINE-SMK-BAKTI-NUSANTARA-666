<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Artikel;

class GuruKomentarController extends Controller
{
    public function index()
    {
        $comments = Comment::with(['user', 'artikel'])->latest()->paginate(20);
        return view('admin.Guru.komentar.index', compact('comments'));
    }

    public function artikel($id)
    {
        $artikel  = Artikel::with('comments.user')->findOrFail($id);
        $comments = $artikel->comments()->with('user')->latest()->paginate(20);
        return view('admin.Guru.komentar.artikel', compact('artikel', 'comments'));
    }
}
