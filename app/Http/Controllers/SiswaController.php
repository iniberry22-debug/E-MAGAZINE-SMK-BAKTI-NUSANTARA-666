<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kategori;
use App\Models\Comment;
use App\Models\Like;
use App\Models\PosterSekolah;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $user  = Auth::user();
        $stats = [
            'my_articles' => Artikel::where('id_user', $user->id_user)->count(),
            'published'   => Artikel::where('id_user', $user->id_user)->where('status', 'published')->count(),
            'pending'     => Artikel::where('id_user', $user->id_user)->where('status', 'pending')->count(),
            'rejected'    => Artikel::where('id_user', $user->id_user)->where('status', 'rejected')->count(),
        ];
        $my_articles = Artikel::where('id_user', $user->id_user)->with('kategori')->latest('tanggal')->limit(5)->get();
        return view('siswa.dashboard', compact('stats', 'my_articles'));
    }

    public function artikelIndex()
    {
        $artikel = Artikel::where('id_user', Auth::user()->id_user)
            ->with('kategori')->latest('tanggal')->paginate(10);
        return view('siswa.artikel.index', compact('artikel'));
    }

    public function artikelCreate()
    {
        $kategoris = Kategori::all();
        return view('siswa.artikel.create', compact('kategoris'));
    }

    public function artikelStore(Request $request)
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

        Artikel::create([
            'judul'       => $request->judul,
            'isi'         => $request->isi,
            'id_user'     => Auth::user()->id_user,
            'id_kategori' => $request->id_kategori,
            'status'      => 'pending',
            'tanggal'     => $request->tanggal,
            'foto'        => $foto,
        ]);

        return redirect()->route('siswa.artikel.index')->with('success', 'Artikel berhasil dikirim, menunggu persetujuan!');
    }

    public function artikelShow($id)
    {
        $artikel = Artikel::with(['kategori', 'comments'])->findOrFail($id);
        return view('siswa.artikel.show', compact('artikel'));
    }

    public function artikelEdit($id)
    {
        $artikel   = Artikel::where('id_user', Auth::user()->id_user)->findOrFail($id);
        $kategoris = Kategori::all();
        return view('siswa.artikel.edit', compact('artikel', 'kategoris'));
    }

    public function artikelUpdate(Request $request, $id)
    {
        $request->validate([
            'judul'       => 'required',
            'isi'         => 'required',
            'id_kategori' => 'required',
            'tanggal'     => 'required|date',
            'foto'        => 'nullable|image|max:2048',
        ]);

        $artikel = Artikel::where('id_user', Auth::user()->id_user)->findOrFail($id);

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
            'status'      => 'pending',
            'tanggal'     => $request->tanggal,
            'foto'        => $foto,
        ]);

        return redirect()->route('siswa.artikel.index')->with('success', 'Artikel berhasil diupdate!');
    }

    public function artikelDestroy($id)
    {
        $artikel = Artikel::where('id_user', Auth::user()->id_user)->findOrFail($id);
        $artikel->delete();
        return back()->with('success', 'Artikel berhasil dihapus!');
    }

    public function posterCreate()
    {
        return view('siswa.poster.create');
    }

    public function posterStore(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'foto'  => 'required|image|max:2048',
        ]);

        $file = $request->file('foto');
        $foto = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $foto);

        PosterSekolah::create([
            'judul'   => $request->judul,
            'foto'    => $foto,
            'id_user' => Auth::user()->id_user,
            'status'  => 'pending',
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Poster berhasil dikirim!');
    }
}
