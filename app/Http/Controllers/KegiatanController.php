<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kegiatan;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Kategori;

class KegiatanController extends Controller
{
    public function details($id)
    {
        $artikel = Kegiatan::with('kategori')->findOrFail($id);
        $likesCount = Like::where('content_type', 'kegiatan')->where('content_id', $id)->count();
        $userLiked = auth()->check() ? Like::where('content_type', 'kegiatan')->where('content_id', $id)->where('user_id', auth()->id())->exists() : false;
        
        // Ambil komentar untuk kegiatan ini
        $artikel->comments = Comment::where('content_type', 'kegiatan')->where('content_id', $id)->latest()->get();
        
        // Ambil kegiatan terkait
        $relatedArticles = Kegiatan::where('id_kegiatan', '!=', $id)
            ->where('status', 'published')
            ->latest()
            ->limit(3)
            ->get();
        
        // Ambil kategori
        $categories = Kategori::withCount(['artikel' => function($query) {
            $query->where('status', 'published');
        }])->get();
        
        return view('blog-details', compact('artikel', 'likesCount', 'userLiked', 'relatedArticles', 'categories'));
    }
    
    public function addComment(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'comment' => 'required|string'
            ]);
            
            $kegiatan = Kegiatan::findOrFail($id);
            
            $comment = Comment::create([
                'content_type' => 'kegiatan',
                'content_id' => $id,
                'judul' => $kegiatan->judul,
                'name' => $request->name,
                'email' => $request->email,
                'comment' => $request->comment
            ]);
            
            return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function toggleLike($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Login required'], 401);
        }

        $kegiatan = Kegiatan::findOrFail($id);
        $userId = auth()->id();
        
        $like = Like::where('content_type', 'kegiatan')
                   ->where('content_id', $id)
                   ->where('user_id', $userId)
                   ->first();
        
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'content_type' => 'kegiatan',
                'content_id' => $id,
                'judul' => $kegiatan->judul,
                'user_id' => $userId,
                'ip_address' => request()->ip()
            ]);
            $liked = true;
        }
        
        $likesCount = Like::where('content_type', 'kegiatan')
                         ->where('content_id', $id)
                         ->count();
        
        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }
}