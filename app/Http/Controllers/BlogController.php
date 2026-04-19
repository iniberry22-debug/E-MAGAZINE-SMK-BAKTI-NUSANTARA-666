<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function details($id)
    {
        $artikel  = Artikel::with(['user', 'kategori', 'comments.user'])->findOrFail($id);
        $comments = $artikel->comments()->with('user')->latest()->get();
        return view('blog-details', compact('artikel', 'comments'));
    }

    public function addComment(Request $request, $id)
    {
        $request->validate(['komentar' => 'required']);

        Comment::create([
            'id_artikel' => $id,
            'id_user'    => Auth::id() ?? null,
            'nama'       => Auth::check() ? Auth::user()->nama : $request->nama,
            'komentar'   => $request->komentar,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function toggleLike($id)
    {
        $existing = Like::where('id_artikel', $id)
            ->where('ip_address', request()->ip())->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            Like::create([
                'id_artikel' => $id,
                'id_user'    => Auth::id() ?? null,
                'ip_address' => request()->ip(),
            ]);
            $liked = true;
        }

        $count = Like::where('id_artikel', $id)->count();
        return response()->json(['liked' => $liked, 'count' => $count]);
    }
}
