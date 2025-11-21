<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::with(['kategori', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);
        
        return view('admin.artikel.index', compact('artikels'));
    }

    public function show($id)
    {
        $artikel = Artikel::with('kategori')->findOrFail($id);
        return view('admin.artikel.show', compact('artikel'));
    }

    public function approve(Request $request, $id)
    {
        $artikel = Artikel::where('status', 'pending')->findOrFail($id);
        $artikel->update([
            'status' => 'published',
            'updated_at' => now()
        ]);
        
        // Log aktivitas
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'aksi' => 'Menyetujui artikel: ' . $artikel->judul
        ]);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dipublikasikan');
    }

    public function reject(Request $request, $id)
    {
        $artikel = Artikel::where('status', 'pending')->findOrFail($id);
        $artikel->update([
            'status' => 'rejected',
            'catatan_review' => $request->catatan_review
        ]);
        
        // Log aktivitas
        LogAktivitas::create([
            'id_user' => Auth::id(),
            'aksi' => 'Menolak artikel: ' . $artikel->judul
        ]);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel ditolak');
    }
}