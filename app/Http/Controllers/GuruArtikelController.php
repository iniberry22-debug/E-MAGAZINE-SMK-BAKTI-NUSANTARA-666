<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class GuruArtikelController extends Controller
{
    public function index()
    {
        $artikel = Artikel::where('id_user', Auth::user()->id_user)
            ->with('kategori')->latest('tanggal')->paginate(10);
        return view('admin.Guru.artikel.index', compact('artikel'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.Guru.artikel.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required',
            'isi'         => 'required',
            'id_kategori' => 'required',
            'tanggal'     => 'required|date',
            'foto'        => 'nullable|image|max:2048',
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $foto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $foto);
        }

        $artikel = Artikel::create([
            'judul'       => $request->judul,
            'isi'         => $request->isi,
            'id_user'     => Auth::user()->id_user,
            'id_kategori' => $request->id_kategori,
            'status'      => $request->status ?? 'draft',
            'tanggal'     => $request->tanggal,
            'foto'        => $foto,
        ]);

        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aksi'    => 'Membuat artikel: ' . $artikel->judul,
        ]);

        return redirect()->route('guru.artikel.index')->with('success', 'Artikel berhasil dibuat!');
    }

    public function show($id)
    {
        $artikel = Artikel::with(['kategori', 'user', 'comments'])->findOrFail($id);
        return view('admin.Guru.artikel.show', compact('artikel'));
    }

    public function edit($id)
    {
        $artikel   = Artikel::findOrFail($id);
        $kategoris = Kategori::all();
        return view('admin.Guru.artikel.edit', compact('artikel', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'       => 'required',
            'isi'         => 'required',
            'id_kategori' => 'required',
            'tanggal'     => 'required|date',
            'foto'        => 'nullable|image|max:2048',
        ]);

        $artikel = Artikel::findOrFail($id);

        $foto = $artikel->foto;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $foto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $foto);
        }

        $artikel->update([
            'judul'       => $request->judul,
            'isi'         => $request->isi,
            'id_kategori' => $request->id_kategori,
            'status'      => $request->status ?? $artikel->status,
            'tanggal'     => $request->tanggal,
            'foto'        => $foto,
        ]);

        return redirect()->route('guru.artikel.index')->with('success', 'Artikel berhasil diupdate!');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();
        return back()->with('success', 'Artikel berhasil dihapus!');
    }
}
