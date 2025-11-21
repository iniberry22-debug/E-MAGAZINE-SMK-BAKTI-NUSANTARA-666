<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\User;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class GuruArtikelSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Artikel::where('status', 'pending')
            ->whereHas('user', function($q) {
                $q->where('role', 'siswa');
            })
            ->with(['user', 'kategori']);
        
        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
        
        $articles = $query->latest('created_at')->paginate(10);
        
        return view('admin.Guru.artikel-siswa.index', compact('articles'));
    }
    
    public function show($id)
    {
        $article = Artikel::where('status', 'pending')
            ->whereHas('user', function($q) {
                $q->where('role', 'siswa');
            })
            ->with(['user', 'kategori'])
            ->findOrFail($id);
        return view('admin.Guru.artikel-siswa.show', compact('article'));
    }
    
    public function approve($id)
    {
        $article = Artikel::where('status', 'pending')
            ->whereHas('user', function($q) {
                $q->where('role', 'siswa');
            })
            ->findOrFail($id);
        
        $article->update([
            'status' => 'published',
            'updated_at' => now()
        ]);
        
        // Log aktivitas
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'aksi' => 'Menyetujui artikel siswa: ' . $article->judul
        ]);
        
        return redirect()->back()->with('success', 'Artikel berhasil disetujui dan dipublikasi');
    }
    
    public function reject(Request $request, $id)
    {
        $article = Artikel::where('status', 'pending')
            ->whereHas('user', function($q) {
                $q->where('role', 'siswa');
            })
            ->findOrFail($id);
        
        $article->update([
            'status' => 'rejected',
            'catatan_review' => $request->catatan_review
        ]);
        
        // Log aktivitas
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'aksi' => 'Menolak artikel siswa: ' . $article->judul
        ]);
        
        return redirect()->back()->with('success', 'Artikel berhasil ditolak');
    }
}