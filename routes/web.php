<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\KaryaSiswaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', function () {
    try {
        $peringatanPosts = \App\Models\Artikel::with('kategori')
            ->whereHas('kategori', fn($q) => $q->whereIn('nama_kategori', ['Peringatan Nasional', 'Ucapan']))
            ->where('status', 'published')->orderBy('updated_at', 'desc')->limit(5)->get();

        $kegiatanPosts = \App\Models\Artikel::with('kategori')
            ->whereHas('kategori', fn($q) => $q->where('nama_kategori', 'Kegiatan Sekolah'))
            ->where('status', 'published')->orderBy('updated_at', 'desc')->get();

        $artikelSiswa = \App\Models\Artikel::with(['kategori', 'user'])
            ->whereHas('kategori', fn($q) => $q->whereNotIn('nama_kategori', ['Peringatan Nasional', 'Ucapan', 'Kegiatan Sekolah']))
            ->where('status', 'published')->orderBy('updated_at', 'desc')->get();

        $allPosts    = \App\Models\Kegiatan::orderBy('updated_at', 'desc')->get();
        $karyaSiswa  = \App\Models\KaryaSiswa::orderBy('updated_at', 'desc')->get();
        $posterSekolah = \App\Models\PosterSekolah::with('user')->where('status', 'published')->orderBy('created_at', 'desc')->limit(6)->get();

        return view('index', compact('peringatanPosts', 'kegiatanPosts', 'artikelSiswa', 'allPosts', 'karyaSiswa', 'posterSekolah'));
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
})->name('home');

Route::get('/artikel/{id}', [BlogController::class, 'details'])->name('blog.details');
Route::post('/artikel/{id}/comment', [BlogController::class, 'addComment'])->name('blog.comment');
Route::post('/artikel/{id}/like', [BlogController::class, 'toggleLike'])->name('blog.like');

Route::get('/kegiatan/{id}', [KegiatanController::class, 'details'])->name('kegiatan.details');
Route::post('/kegiatan/{id}/comment', [KegiatanController::class, 'addComment'])->name('kegiatan.comment');
Route::post('/kegiatan/{id}/like', [KegiatanController::class, 'toggleLike'])->name('kegiatan.like');

Route::get('/karya-siswa/{id}', [KaryaSiswaController::class, 'details'])->name('karya.details');
Route::post('/karya-siswa/{id}/comment', [KaryaSiswaController::class, 'addComment'])->name('karya.comment');
Route::post('/karya-siswa/{id}/like', [KaryaSiswaController::class, 'toggleLike'])->name('karya.like');

Route::get('/search-results', function (\Illuminate\Http\Request $request) {
    $query    = $request->get('q', '');
    $category = $request->get('category', '');
    $date     = $request->get('date', '');
    $page     = $request->get('page', 1);
    $perPage  = 12;

    $allResults = collect();

    if ($query || $category || $date) {
        $artikelQuery = \App\Models\Artikel::with(['kategori', 'user'])->where('status', 'published');
        if ($query) $artikelQuery->where(fn($q) => $q->where('judul', 'like', "%$query%")->orWhere('isi', 'like', "%$query%"));
        if ($category) $artikelQuery->whereHas('kategori', fn($q) => $q->where('nama_kategori', 'like', "%$category%"));
        if ($date) $artikelQuery->whereDate('tanggal', $date);

        $artikel = $artikelQuery->get()->map(fn($item) => (object)[
            'id' => $item->id_artikel, 'judul' => $item->judul, 'isi' => $item->isi,
            'tanggal' => $item->tanggal, 'foto' => $item->foto,
            'kategori' => $item->kategori->nama_kategori ?? '', 'penulis' => $item->user->nama ?? '', 'type' => 'artikel'
        ]);

        $allResults = $artikel;
    }

    $total     = $allResults->count();
    $results   = $allResults->forPage($page, $perPage);
    $paginator = new \Illuminate\Pagination\LengthAwarePaginator($results, $total, $perPage, $page, ['path' => $request->url(), 'query' => $request->query()]);
    $categories = \App\Models\Kategori::all();

    return view('search-results', compact('paginator', 'query', 'category', 'date', 'categories'));
})->name('search.results');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/comments', [AdminController::class, 'comments'])->name('admin.comments');
    Route::get('/likes', [AdminController::class, 'likes'])->name('admin.likes');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');

    Route::resource('kategori', KategoriController::class, ['as' => 'admin']);
    Route::resource('users', UserController::class, ['as' => 'admin']);

    Route::get('artikel', [ArtikelController::class, 'index'])->name('admin.artikel.index');
    Route::get('artikel/{id}', [ArtikelController::class, 'show'])->name('admin.artikel.show');
    Route::post('artikel/{id}/approve', [ArtikelController::class, 'approve'])->name('admin.artikel.approve');
    Route::post('artikel/{id}/reject', [ArtikelController::class, 'reject'])->name('admin.artikel.reject');

    Route::get('poster', [AdminController::class, 'posterIndex'])->name('admin.poster.index');
    Route::post('poster/{id}/publish', [AdminController::class, 'posterPublish'])->name('admin.poster.publish');
});

// Guru Routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\GuruController::class, 'dashboard'])->name('guru.dashboard');

    Route::prefix('artikel')->group(function () {
        Route::get('/', [\App\Http\Controllers\GuruArtikelController::class, 'index'])->name('guru.artikel.index');
        Route::get('/create', [\App\Http\Controllers\GuruArtikelController::class, 'create'])->name('guru.artikel.create');
        Route::post('/', [\App\Http\Controllers\GuruArtikelController::class, 'store'])->name('guru.artikel.store');
        Route::get('/{id}', [\App\Http\Controllers\GuruArtikelController::class, 'show'])->name('guru.artikel.show');
        Route::get('/{id}/edit', [\App\Http\Controllers\GuruArtikelController::class, 'edit'])->name('guru.artikel.edit');
        Route::put('/{id}', [\App\Http\Controllers\GuruArtikelController::class, 'update'])->name('guru.artikel.update');
        Route::delete('/{id}', [\App\Http\Controllers\GuruArtikelController::class, 'destroy'])->name('guru.artikel.destroy');
    });

    Route::prefix('artikel-siswa')->group(function () {
        Route::get('/', [\App\Http\Controllers\GuruArtikelSiswaController::class, 'index'])->name('guru.artikel-siswa.index');
        Route::get('/{id}', [\App\Http\Controllers\GuruArtikelSiswaController::class, 'show'])->name('guru.artikel-siswa.show');
        Route::post('/{id}/approve', [\App\Http\Controllers\GuruArtikelSiswaController::class, 'approve'])->name('guru.artikel-siswa.approve');
        Route::post('/{id}/reject', [\App\Http\Controllers\GuruArtikelSiswaController::class, 'reject'])->name('guru.artikel-siswa.reject');
    });

    Route::get('/komentar', [\App\Http\Controllers\GuruKomentarController::class, 'index'])->name('guru.komentar.index');
    Route::get('/komentar/artikel/{id}', [\App\Http\Controllers\GuruKomentarController::class, 'artikel'])->name('guru.komentar.artikel');

    Route::get('/poster', [\App\Http\Controllers\GuruController::class, 'posterIndex'])->name('guru.poster.index');
    Route::post('/poster/{id}/approve', [\App\Http\Controllers\GuruController::class, 'posterApprove'])->name('guru.poster.approve');
});

// Siswa Routes
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('siswa.dashboard');

    Route::prefix('artikel')->group(function () {
        Route::get('/', [SiswaController::class, 'artikelIndex'])->name('siswa.artikel.index');
        Route::get('/create', [SiswaController::class, 'artikelCreate'])->name('siswa.artikel.create');
        Route::post('/', [SiswaController::class, 'artikelStore'])->name('siswa.artikel.store');
        Route::get('/{id}', [SiswaController::class, 'artikelShow'])->name('siswa.artikel.show');
        Route::get('/{id}/edit', [SiswaController::class, 'artikelEdit'])->name('siswa.artikel.edit');
        Route::put('/{id}', [SiswaController::class, 'artikelUpdate'])->name('siswa.artikel.update');
        Route::delete('/{id}', [SiswaController::class, 'artikelDestroy'])->name('siswa.artikel.destroy');
    });

    Route::get('/poster/create', [SiswaController::class, 'posterCreate'])->name('siswa.poster.create');
    Route::post('/poster', [SiswaController::class, 'posterStore'])->name('siswa.poster.store');
});
