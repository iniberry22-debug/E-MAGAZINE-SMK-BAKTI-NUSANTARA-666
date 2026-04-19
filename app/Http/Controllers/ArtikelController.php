<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::with(['user', 'kategori'])->latest()->paginate(15);
        return view('admin.artikel.index', compact('artikel'));
    }

    public function show($id)
    {
        $artikel = Artikel::with(['user', 'kategori', 'comments'])->findOrFail($id);
        return view('admin.artikel.show', compact('artikel'));
    }

    public function approve($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update(['status' => 'published']);

        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aksi'    => 'Mempublish artikel: ' . $artikel->judul,
        ]);

        return back()->with('success', 'Artikel berhasil dipublish!');
    }

    public function reject(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update([
            'status'         => 'rejected',
            'catatan_review' => $request->catatan_review,
        ]);

        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aksi'    => 'Menolak artikel: ' . $artikel->judul,
        ]);

        return back()->with('success', 'Artikel berhasil ditolak!');
    }
}
