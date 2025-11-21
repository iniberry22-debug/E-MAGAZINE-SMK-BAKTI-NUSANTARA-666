<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Kategori;

class BlogController extends Controller
{
    public function details($id)
    {
        $artikel = Artikel::with(['comments', 'likes', 'kategori'])->findOrFail($id);
        
        // Hitung total likes
        $likesCount = Like::where('artikel_id', $id)->count();
        
        // Cek apakah user saat ini sudah like artikel ini
        $userLiked = auth()->check() ? 
            Like::where('artikel_id', $id)
                ->where('user_id', auth()->id())
                ->exists() : false;
        
        $relatedArticles = Artikel::where('id_artikel', '!=', $id)
            ->where('status', 'published')
            ->latest()
            ->limit(3)
            ->get();
        
        $categories = Kategori::withCount(['artikel' => function($query) {
            $query->where('status', 'published');
        }])->get();
        
        return view('blog-details', compact('artikel', 'likesCount', 'userLiked', 'relatedArticles', 'categories'));
    }

    public function addComment(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memberikan komentar');
        }

        $request->validate([
            'comment' => 'required|string'
        ]);

        Comment::create([
            'artikel_id' => $id,
            'user_id' => auth()->id(),
            'name' => auth()->user()->nama,
            'email' => auth()->user()->username . '@siswa.com',
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function toggleLike($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu untuk menyukai artikel ini'], 401);
        }

        try {
            $userId = auth()->id();
            
            // Cek hanya berdasarkan user_id
            $like = Like::where('artikel_id', $id)
                       ->where('user_id', $userId)
                       ->first();

            if ($like) {
                $like->delete();
                $liked = false;
            } else {
                Like::create([
                    'artikel_id' => $id,
                    'user_id' => $userId,
                    'ip_address' => request()->ip()
                ]);
                $liked = true;
            }

            $likesCount = Like::where('artikel_id', $id)->count();

            return response()->json([
                'liked' => $liked,
                'likes_count' => $likesCount
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan'], 500);
        }
    }
}