<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{


    public function index()
    {
        $kategoris = Kategori::latest()->paginate(10);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        Kategori::create(['nama_kategori' => $request->nama_kategori]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        $kategori->update(['nama_kategori' => $request->nama_kategori]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $artikelCount = DB::table('artikel')->where('id_kategori', $id)->count();
        
        if ($artikelCount > 0) {
            return redirect()->route('admin.kategori.index')->with('error', 'Tidak dapat menghapus kategori karena masih digunakan oleh ' . $artikelCount . ' artikel');
        }
        
        DB::table('kategori')->where('id_kategori', $id)->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}