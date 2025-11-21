<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KaryaSiswa;
use App\Models\Comment;
use App\Models\Like;

class KaryaSiswaController extends Controller
{
    public function details($id)
    {
        $karya = KaryaSiswa::findOrFail($id);
        $likesCount = Like::where('content_type', 'karya')->where('content_id', $id)->count();
        $userLiked = auth()->check() ? Like::where('content_type', 'karya')->where('content_id', $id)->where('user_id', auth()->id())->exists() : false;
        
        // Ambil komentar untuk karya ini
        $karya->comments = Comment::where('content_type', 'karya')->where('content_id', $id)->latest()->get();
        
        // Ambil karya terkait
        $relatedArticles = KaryaSiswa::where('id_karya', '!=', $id)
            ->where('kategori', $karya->kategori)
            ->latest()
            ->limit(3)
            ->get();
        
        // Jika tidak ada karya dengan kategori sama, ambil karya terbaru
        if ($relatedArticles->count() < 3) {
            $relatedArticles = KaryaSiswa::where('id_karya', '!=', $id)
                ->latest()
                ->limit(3)
                ->get();
        }
        
        // Ambil kategori (untuk karya siswa, kita buat array manual)
        $categories = collect([
            (object)['nama_kategori' => 'Puisi', 'artikel_count' => KaryaSiswa::where('kategori', 'Puisi')->count()],
            (object)['nama_kategori' => 'Cerpen', 'artikel_count' => KaryaSiswa::where('kategori', 'Cerpen')->count()],
            (object)['nama_kategori' => 'Artikel', 'artikel_count' => KaryaSiswa::where('kategori', 'Artikel')->count()],
            (object)['nama_kategori' => 'Opini', 'artikel_count' => KaryaSiswa::where('kategori', 'Opini')->count()],
        ])->filter(function($cat) { return $cat->artikel_count > 0; });
        
        return view('blog-details', compact('karya', 'likesCount', 'userLiked', 'relatedArticles', 'categories'));
    }
    
    public function addComment(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'comment' => 'required|string'
            ]);
            
            $karya = KaryaSiswa::findOrFail($id);
            
            $comment = Comment::create([
                'content_type' => 'karya',
                'content_id' => $id,
                'judul' => $karya->judul,
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

        $karya = KaryaSiswa::findOrFail($id);
        $userId = auth()->id();
        
        $like = Like::where('content_type', 'karya')
                   ->where('content_id', $id)
                   ->where('user_id', $userId)
                   ->first();
        
        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'content_type' => 'karya',
                'content_id' => $id,
                'judul' => $karya->judul,
                'user_id' => $userId,
                'ip_address' => request()->ip()
            ]);
            $liked = true;
        }
        
        $likesCount = Like::where('content_type', 'karya')
                         ->where('content_id', $id)
                         ->count();
        
        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }
}