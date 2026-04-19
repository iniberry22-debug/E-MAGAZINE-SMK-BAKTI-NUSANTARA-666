<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    public function details($id)
    {
        $kegiatan = Kegiatan::with(['user', 'comments.user'])->findOrFail($id);
        $comments = $kegiatan->comments()->with('user')->latest()->get();
        return view('kegiatan-details', compact('kegiatan', 'comments'));
    }

    public function addComment(Request $request, $id)
    {
        $request->validate(['komentar' => 'required']);

        Comment::create([
            'id_kegiatan' => $id,
            'id_user'     => Auth::id() ?? null,
            'nama'        => Auth::check() ? Auth::user()->nama : $request->nama,
            'komentar'    => $request->komentar,
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function toggleLike($id)
    {
        $existing = Like::where('id_kegiatan', $id)
            ->where('ip_address', request()->ip())->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            Like::create([
                'id_kegiatan' => $id,
                'id_user'     => Auth::id() ?? null,
                'ip_address'  => request()->ip(),
            ]);
            $liked = true;
        }

        $count = Like::where('id_kegiatan', $id)->count();
        return response()->json(['liked' => $liked, 'count' => $count]);
    }
}
