<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class GuruArtikelSiswaController extends Controller
{
    public function index()
    {
        $artikel = Artikel::whereHas('user', fn($q) => $q->where('role', 'siswa'))
            ->with(['user', 'kategori'])->latest('tanggal')->paginate(10);
        return view('admin.Guru.artikel-siswa.index', compact('artikel'));
    }

    public function show($id)
    {
        $artikel = Artikel::with(['user', 'kategori', 'comments'])->findOrFail($id);
        return view('admin.Guru.artikel-siswa.show', compact('artikel'));
    }

    public function approve($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update(['status' => 'approved']);

        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aksi'    => 'Menyetujui artikel siswa: ' . $artikel->judul,
        ]);

        return back()->with('success', 'Artikel berhasil disetujui!');
    }

    public function reject(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->update([
            'status'          => 'rejected',
            'catatan_review'  => $request->catatan_review,
        ]);

        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aksi'    => 'Menolak artikel siswa: ' . $artikel->judul,
        ]);

        return back()->with('success', 'Artikel berhasil ditolak!');
    }
}
