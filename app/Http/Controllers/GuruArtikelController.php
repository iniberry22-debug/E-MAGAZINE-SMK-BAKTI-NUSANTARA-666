<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuruArtikelController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Artikel::where(function($q) use ($user) {
                $q->where('id_user', $user->id_user)
                  ->orWhere(function($subq) {
                      $subq->whereHas('user', function($userq) {
                          $userq->where('role', 'siswa');
                      })->whereIn('status', ['approved', 'published']);
                  });
            })->with(['kategori', 'user']);
        
        // Filter by search
        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        
        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by category
        if ($request->category) {
            $query->where('id_kategori', $request->category);
        }
        
        $articles = $query->latest('tanggal')->paginate(10);
        $categories = \App\Models\Kategori::all();
        
        return view('admin.Guru.artikel.index', compact('articles', 'categories'));
    }
    
    public function create()
    {
        $kategori = \App\Models\Kategori::all();
        return view('admin.Guru.artikel.create', compact('kategori'));
    }
    
    public function store(Request $request)
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
            'id_user' => Auth::user()->id_user,
            'tanggal' => now(),
            'status' => 'published'
        ];
        
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads'), $filename);
            $data['foto'] = $filename;
        }
        
        Artikel::create($data);
        
        return redirect()->route('guru.artikel.index')->with('success', 'Artikel berhasil dibuat');
    }
    
    public function show($id)
    {
        $user = Auth::user();
        $article = Artikel::where('id_artikel', $id)
            ->where(function($q) use ($user) {
                $q->where('id_user', $user->id_user)
                  ->orWhere(function($subq) {
                      $subq->whereHas('user', function($userq) {
                          $userq->where('role', 'siswa');
                      })->whereIn('status', ['approved', 'published']);
                  });
            })
            ->with(['kategori', 'user'])
            ->firstOrFail();
        return view('admin.Guru.artikel.show', compact('article'));
    }
    
    public function edit($id)
    {
        $user = Auth::user();
        $article = Artikel::where('id_artikel', $id)->where('id_user', $user->id_user)->firstOrFail();
        $categories = \App\Models\Kategori::all();
        return view('admin.Guru.artikel.edit', compact('article', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $article = Artikel::where('id_artikel', $id)->where('id_user', $user->id_user)->firstOrFail();
        
        $request->validate([
            'judul' => 'required|max:255',
            'isi' => 'required',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $data = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'id_kategori' => $request->id_kategori
        ];
        
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($article->foto && file_exists(public_path('uploads/' . $article->foto))) {
                unlink(public_path('uploads/' . $article->foto));
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads'), $filename);
            $data['foto'] = $filename;
        }
        
        $article->update($data);
        
        return redirect()->route('guru.artikel.index')->with('success', 'Artikel berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $user = Auth::user();
        $article = Artikel::where('id_artikel', $id)->where('id_user', $user->id_user)->firstOrFail();
        
        $article->delete();
        
        return redirect()->route('guru.artikel.index')->with('success', 'Artikel berhasil dihapus');
    }
    
    public function publish($id)
    {
        $article = Artikel::where('id', $id)->where('author_id', Auth::id())->firstOrFail();
        $article->update(['status' => 'published']);
        
        return redirect()->back()->with('success', 'Artikel berhasil dipublish');
    }
    
    public function unpublish($id)
    {
        $article = Artikel::where('id', $id)->where('author_id', Auth::id())->firstOrFail();
        $article->update(['status' => 'draft']);
        
        return redirect()->back()->with('success', 'Artikel berhasil di-unpublish');
    }
}