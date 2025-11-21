<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Comment;
use App\Models\Kategori;
use App\Models\Like;
use App\Models\PosterSekolah;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $artikelSaya = Artikel::where('id_user', Auth::id())->latest()->get();
        $totalArtikel = $artikelSaya->count();
        $artikelPublished = $artikelSaya->where('status', 'published')->count();
        $artikelPending = $artikelSaya->where('status', 'pending')->count();
        $artikelApproved = $artikelSaya->where('status', 'approved')->count();
        $artikelRejected = $artikelSaya->where('status', 'rejected')->count();
        
        return view('siswa.dashboard', compact('artikelSaya', 'totalArtikel', 'artikelPublished', 'artikelPending', 'artikelApproved', 'artikelRejected'));
    }

    public function artikelIndex()
    {
        $artikel = Artikel::where('id_user', Auth::id())->latest()->paginate(10);
        return view('siswa.artikel.index', compact('artikel'));
    }

    public function artikelCreate()
    {
        $kategori = Kategori::all();
        return view('siswa.artikel.create', compact('kategori'));
    }

    public function artikelStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'id_kategori' => $request->id_kategori,
            'id_user' => Auth::id(),
            'tanggal' => now(),
            'status' => 'pending'
        ];

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads'), $filename);
            $data['foto'] = $filename;
        }

        $artikel = Artikel::create($data);
        
        // Log aktivitas
        \Log::info('Artikel baru dibuat', [
            'user_id' => Auth::id(),
            'artikel_id' => $artikel->id_artikel,
            'judul' => $artikel->judul
        ]);

        return redirect()->route('siswa.artikel.index')->with('success', 'Artikel berhasil dibuat dan menunggu persetujuan');
    }

    public function artikelShow($id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::id())->firstOrFail();
        return view('siswa.artikel.show', compact('artikel'));
    }

    public function artikelEdit($id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::id())->firstOrFail();
        $kategori = Kategori::all();
        return view('siswa.artikel.edit', compact('artikel', 'kategori'));
    }

    public function artikelUpdate(Request $request, $id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::id())->firstOrFail();
        
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'id_kategori' => $request->id_kategori,
            'status' => 'pending',
            'catatan_review' => null
        ];

        if ($request->hasFile('foto')) {
            if ($artikel->foto && file_exists(public_path('uploads/' . $artikel->foto))) {
                unlink(public_path('uploads/' . $artikel->foto));
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads'), $filename);
            $data['foto'] = $filename;
        }

        $artikel->update($data);

        return redirect()->route('siswa.artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }

    public function artikelDestroy($id)
    {
        $artikel = Artikel::where('id_artikel', $id)->where('id_user', Auth::id())->firstOrFail();
        
        if ($artikel->foto && file_exists(public_path('uploads/' . $artikel->foto))) {
            unlink(public_path('uploads/' . $artikel->foto));
        }
        
        $artikel->delete();

        return redirect()->route('siswa.artikel.index')->with('success', 'Artikel berhasil dihapus');
    }

    // Fungsi untuk membaca artikel published
    public function bacaArtikel()
    {
        $artikel = Artikel::where('status', 'published')
            ->with(['kategori', 'user', 'comments.user'])
            ->latest()
            ->paginate(10);
        return view('siswa.baca-artikel', compact('artikel'));
    }

    public function detailArtikel($id)
    {
        $artikel = Artikel::where('id_artikel', $id)
            ->where('status', 'published')
            ->with(['kategori', 'user', 'comments.user', 'likes'])
            ->firstOrFail();
        
        $isLiked = $artikel->likes()->where('ip_address', request()->ip())->exists();
        
        return view('siswa.detail-artikel', compact('artikel', 'isLiked'));
    }

    public function addComment(Request $request, $id)
    {
        $request->validate([
            'isi_komentar' => 'required|max:500'
        ]);

        $artikel = Artikel::where('id_artikel', $id)
            ->where('status', 'published')
            ->firstOrFail();

        $comment = Comment::create([
            'artikel_id' => $artikel->id_artikel,
            'user_id' => Auth::id(),
            'comment' => $request->isi_komentar,
            'name' => Auth::user()->nama,
            'email' => Auth::user()->email ?? 'no-email@example.com'
        ]);
        
        // Log aktivitas
        \Log::info('Komentar baru ditambahkan', [
            'user_id' => Auth::id(),
            'artikel_id' => $artikel->id_artikel,
            'comment_id' => $comment->id
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan');
    }

    public function toggleLike($id)
    {
        $artikel = Artikel::where('id_artikel', $id)
            ->where('status', 'published')
            ->firstOrFail();

        $like = Like::where('artikel_id', $artikel->id_artikel)
            ->where('ip_address', request()->ip())
            ->first();

        if ($like) {
            $like->delete();
            $message = 'Like dihapus';
        } else {
            $newLike = Like::create([
                'artikel_id' => $artikel->id_artikel,
                'ip_address' => request()->ip()
            ]);
            $message = 'Artikel dilike';
            
            // Log aktivitas
            \Log::info('Like ditambahkan', [
                'user_id' => Auth::id(),
                'artikel_id' => $artikel->id_artikel,
                'like_id' => $newLike->id
            ]);
        }

        return back()->with('success', $message);
    }
    
    // Poster Methods
    public function posterCreate()
    {
        return view('siswa.poster.create');
    }
    
    public function posterStore(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'kategori' => 'required|max:100'
        ]);
        
        $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
        $request->file('foto')->move(public_path('uploads'), $filename);
        
        $poster = PosterSekolah::create([
            'judul' => $request->judul,
            'foto' => $filename,
            'kategori' => $request->kategori,
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);
        
        // Log aktivitas
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'aksi' => 'Membuat poster baru: ' . $request->judul
        ]);
        
        return redirect()->route('home')->with('success', 'Poster berhasil dibuat dan menunggu persetujuan guru!');
    }
}