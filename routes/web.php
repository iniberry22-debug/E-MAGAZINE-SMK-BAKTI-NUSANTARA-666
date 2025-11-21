<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\KaryaSiswaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/debug-poster', function () {
    $posters = \App\Models\PosterSekolah::select('judul', 'status', 'created_at')->get();
    return $posters->map(function($p) {
        return $p->judul . ' - Status: ' . $p->status . ' - ' . $p->created_at->format('d/m/Y H:i');
    })->implode('<br>');
});

Route::get('/debug-search', function () {
    $query = request('q', 'pramuka');
    
    // Test search
    $artikel = \DB::table('artikel')
        ->select('id_artikel as id', 'judul', 'status')
        ->where('status', 'published')
        ->where(function($q) use ($query) {
            $q->where('judul', 'like', '%' . $query . '%')
              ->orWhere('isi', 'like', '%' . $query . '%');
        })
        ->get();
    
    $karyaSiswa = \DB::table('karya_siswa')
        ->select('id_karya as id', 'judul')
        ->where(function($q) use ($query) {
            $q->where('judul', 'like', '%' . $query . '%')
              ->orWhere('isi', 'like', '%' . $query . '%');
        })
        ->get();
    
    $results = $artikel->concat($karyaSiswa);
    
    return 'Query: ' . $query . '<br>Results: ' . $results->count() . '<br><br>' . 
           $results->map(function($r) { return $r->judul; })->implode('<br>');
});

Route::get('/', function () {
    try {
        // Artikel hari peringatan/ucapan (tampil paling atas)
        $peringatanPosts = \App\Models\Artikel::with('kategori')
            ->whereHas('kategori', function($q) {
                $q->whereIn('nama_kategori', ['Peringatan Nasional', 'Ucapan']);
            })
            ->where('status', 'published')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
        
        // Artikel kegiatan (hanya kategori Kegiatan Sekolah)
        $kegiatanPosts = \App\Models\Artikel::with('kategori')
            ->whereHas('kategori', function($q) {
                $q->where('nama_kategori', 'Kegiatan Sekolah');
            })
            ->where('status', 'published')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        // Artikel siswa/guru (semua kategori kecuali Peringatan Nasional, Ucapan, dan Kegiatan Sekolah)
        $artikelSiswa = \App\Models\Artikel::with(['kategori', 'user'])
            ->whereHas('kategori', function($q) {
                $q->whereNotIn('nama_kategori', ['Peringatan Nasional', 'Ucapan', 'Kegiatan Sekolah']);
            })
            ->where('status', 'published')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        // Kegiatan dari tabel kegiatan
        $allPosts = \App\Models\Kegiatan::orderBy('updated_at', 'desc')->get();
        
        // Karya siswa dari tabel karya_siswa
        $karyaSiswa = \App\Models\KaryaSiswa::orderBy('updated_at', 'desc')->get();
        
        // Poster sekolah (hanya yang published)
        $posterSekolah = \App\Models\PosterSekolah::with('user')->where('status', 'published')->orderBy('created_at', 'desc')->limit(6)->get();
        
        // Debug: cek semua poster
        \Log::info('Total poster published: ' . $posterSekolah->count());
        \Log::info('Total poster approved: ' . \App\Models\PosterSekolah::where('status', 'approved')->count());
        
        return view('index', compact('peringatanPosts', 'kegiatanPosts', 'artikelSiswa', 'allPosts', 'karyaSiswa', 'posterSekolah'));
    } catch (Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/category', function () {
    return view('category');
})->name('category');

Route::get('/artikel/{id}', [BlogController::class, 'details'])->name('blog.details');
Route::post('/artikel/{id}/comment', [BlogController::class, 'addComment'])->name('blog.comment');
Route::post('/artikel/{id}/like', [BlogController::class, 'toggleLike'])->name('blog.like');

Route::get('/kegiatan/{id}', [KegiatanController::class, 'details'])->name('kegiatan.details');
Route::post('/kegiatan/{id}/comment', [KegiatanController::class, 'addComment'])->name('kegiatan.comment');
Route::post('/kegiatan/{id}/like', [KegiatanController::class, 'toggleLike'])->name('kegiatan.like');

Route::get('/karya-siswa/{id}', [KaryaSiswaController::class, 'details'])->name('karya.details');
Route::post('/karya-siswa/{id}/comment', [KaryaSiswaController::class, 'addComment'])->name('karya.comment');
Route::post('/karya-siswa/{id}/like', [KaryaSiswaController::class, 'toggleLike'])->name('karya.like');

Route::get('/author-profile', function () {
    return view('author-profile');
})->name('author-profile');

Route::get('/search-results', function (\Illuminate\Http\Request $request) {
    $query = $request->get('q', '');
    $category = $request->get('category', '');
    $date = $request->get('date', '');
    $page = $request->get('page', 1);
    $perPage = 12;
    
    $allResults = collect();
    
    if ($query || $category || $date) {
        // Cari di artikel (hanya yang published)
        $artikelQuery = \App\Models\Artikel::with(['kategori', 'user'])
            ->where('status', 'published');
        
        // Filter berdasarkan judul atau isi
        if ($query) {
            $artikelQuery->where(function($q) use ($query) {
                $q->where('judul', 'like', '%' . $query . '%')
                  ->orWhere('isi', 'like', '%' . $query . '%');
            });
        }
        
        // Filter berdasarkan kategori
        if ($category) {
            $artikelQuery->whereHas('kategori', function($q) use ($category) {
                $q->where('nama_kategori', 'like', '%' . $category . '%');
            });
        }
        
        // Filter berdasarkan tanggal
        if ($date) {
            $artikelQuery->whereDate('tanggal', $date);
        }
        
        $artikel = $artikelQuery->get()->map(function($item) {
            return (object) [
                'id' => $item->id_artikel,
                'judul' => $item->judul,
                'isi' => $item->isi,
                'tanggal' => $item->tanggal,
                'foto' => $item->foto,
                'kategori' => $item->kategori->nama_kategori ?? '',
                'penulis' => $item->user->nama ?? '',
                'type' => 'artikel'
            ];
        });
        
        // Cari di karya siswa
        $karyaQuery = \App\Models\KaryaSiswa::query();
        
        if ($query) {
            $karyaQuery->where(function($q) use ($query) {
                $q->where('judul', 'like', '%' . $query . '%')
                  ->orWhere('isi', 'like', '%' . $query . '%');
            });
        }
        
        if ($category) {
            $karyaQuery->where('kategori', 'like', '%' . $category . '%');
        }
        
        if ($date) {
            $karyaQuery->whereDate('tanggal', $date);
        }
        
        $karyaSiswa = $karyaQuery->get()->map(function($item) {
            return (object) [
                'id' => $item->id_karya,
                'judul' => $item->judul,
                'isi' => $item->isi,
                'tanggal' => $item->tanggal,
                'kategori' => $item->kategori,
                'penulis' => $item->penulis,
                'type' => 'karya'
            ];
        });
        
        // Gabungkan hasil
        $allResults = $artikel->concat($karyaSiswa);
    }
    
    // Manual pagination
    $total = $allResults->count();
    $results = $allResults->forPage($page, $perPage);
    
    $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
        $results,
        $total,
        $perPage,
        $page,
        ['path' => $request->url(), 'query' => $request->query()]
    );
    
    $categories = \App\Models\Kategori::all();
    
    return view('search-results', compact('paginator', 'query', 'category', 'date', 'categories'));
})->name('search.results');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

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
    Route::get('/reports/export', [AdminController::class, 'exportPdf'])->name('admin.reports.export');
    Route::get('/reports/excel', [AdminController::class, 'exportExcel'])->name('admin.reports.excel');
    
    // Kategori Management
    Route::resource('kategori', KategoriController::class, ['as' => 'admin']);
    
    // User Management
    Route::resource('users', UserController::class, ['as' => 'admin']);
    Route::get('users/{id}/reset-password', [\App\Http\Controllers\PasswordResetController::class, 'showResetForm'])->name('admin.users.reset-password-form');
    Route::post('users/{id}/reset-password', [\App\Http\Controllers\PasswordResetController::class, 'resetPassword'])->name('admin.users.reset-password');
    Route::post('users/{id}/generate-password', [\App\Http\Controllers\PasswordResetController::class, 'generateRandomPassword'])->name('admin.users.generate-password');
    
    // Artikel Verification
    Route::get('artikel', [ArtikelController::class, 'index'])->name('admin.artikel.index');
    Route::get('artikel/{id}', [ArtikelController::class, 'show'])->name('admin.artikel.show');
    Route::post('artikel/{id}/approve', [ArtikelController::class, 'approve'])->name('admin.artikel.approve');
    Route::post('artikel/{id}/reject', [ArtikelController::class, 'reject'])->name('admin.artikel.reject');
    
    // Poster Management
    Route::get('poster', [AdminController::class, 'posterIndex'])->name('admin.poster.index');
    Route::post('poster/{id}/publish', [AdminController::class, 'posterPublish'])->name('admin.poster.publish');
});

// Guru Routes
Route::middleware(['auth', 'role:guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\GuruController::class, 'dashboard'])->name('guru.dashboard');
    
    // Artikel Management for Guru
    Route::prefix('artikel')->group(function () {
        Route::get('/', [\App\Http\Controllers\GuruArtikelController::class, 'index'])->name('guru.artikel.index');
        Route::get('/create', [\App\Http\Controllers\GuruArtikelController::class, 'create'])->name('guru.artikel.create');
        Route::post('/', [\App\Http\Controllers\GuruArtikelController::class, 'store'])->name('guru.artikel.store');
        Route::get('/{id}', [\App\Http\Controllers\GuruArtikelController::class, 'show'])->name('guru.artikel.show');
        Route::get('/{id}/edit', [\App\Http\Controllers\GuruArtikelController::class, 'edit'])->name('guru.artikel.edit');
        Route::put('/{id}', [\App\Http\Controllers\GuruArtikelController::class, 'update'])->name('guru.artikel.update');
        Route::delete('/{id}', [\App\Http\Controllers\GuruArtikelController::class, 'destroy'])->name('guru.artikel.destroy');
    });
    
    // Student Articles Management
    Route::prefix('artikel-siswa')->group(function () {
        Route::get('/', [\App\Http\Controllers\GuruArtikelSiswaController::class, 'index'])->name('guru.artikel-siswa.index');
        Route::get('/{id}', [\App\Http\Controllers\GuruArtikelSiswaController::class, 'show'])->name('guru.artikel-siswa.show');
        Route::post('/{id}/approve', [\App\Http\Controllers\GuruArtikelSiswaController::class, 'approve'])->name('guru.artikel-siswa.approve');
        Route::post('/{id}/reject', [\App\Http\Controllers\GuruArtikelSiswaController::class, 'reject'])->name('guru.artikel-siswa.reject');
    });
    
    // Comments Management
    Route::get('/komentar', [\App\Http\Controllers\GuruKomentarController::class, 'index'])->name('guru.komentar.index');
    Route::get('/komentar/artikel/{id}', [\App\Http\Controllers\GuruKomentarController::class, 'artikel'])->name('guru.komentar.artikel');
    
    // Poster Management
    Route::get('/poster', [\App\Http\Controllers\GuruController::class, 'posterIndex'])->name('guru.poster.index');
    Route::post('/poster/{id}/approve', [\App\Http\Controllers\GuruController::class, 'posterApprove'])->name('guru.poster.approve');
});

// Siswa Routes
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\SiswaController::class, 'dashboard'])->name('siswa.dashboard');
    
    // Artikel Management for Siswa
    Route::prefix('artikel')->group(function () {
        Route::get('/', [\App\Http\Controllers\SiswaController::class, 'artikelIndex'])->name('siswa.artikel.index');
        Route::get('/create', [\App\Http\Controllers\SiswaController::class, 'artikelCreate'])->name('siswa.artikel.create');
        Route::post('/', [\App\Http\Controllers\SiswaController::class, 'artikelStore'])->name('siswa.artikel.store');
        Route::get('/{id}', [\App\Http\Controllers\SiswaController::class, 'artikelShow'])->name('siswa.artikel.show');
        Route::get('/{id}/edit', [\App\Http\Controllers\SiswaController::class, 'artikelEdit'])->name('siswa.artikel.edit');
        Route::put('/{id}', [\App\Http\Controllers\SiswaController::class, 'artikelUpdate'])->name('siswa.artikel.update');
        Route::delete('/{id}', [\App\Http\Controllers\SiswaController::class, 'artikelDestroy'])->name('siswa.artikel.destroy');
    });
    
    // Routes untuk membaca artikel published
    Route::get('/baca-artikel', [\App\Http\Controllers\SiswaController::class, 'bacaArtikel'])->name('siswa.baca-artikel');
    Route::get('/artikel-detail/{id}', [\App\Http\Controllers\SiswaController::class, 'detailArtikel'])->name('siswa.artikel-detail');
    Route::post('/artikel-detail/{id}/comment', [\App\Http\Controllers\SiswaController::class, 'addComment'])->name('siswa.artikel.comment');
    Route::post('/artikel-detail/{id}/like', [\App\Http\Controllers\SiswaController::class, 'toggleLike'])->name('siswa.artikel.like');
    
    // Poster Routes
    Route::get('/poster/create', [\App\Http\Controllers\SiswaController::class, 'posterCreate'])->name('siswa.poster.create');
    Route::post('/poster', [\App\Http\Controllers\SiswaController::class, 'posterStore'])->name('siswa.poster.store');
});
