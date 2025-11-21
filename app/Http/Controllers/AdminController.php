<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Kegiatan;
use App\Models\KaryaSiswa;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Kategori;
use App\Models\PosterSekolah;
use App\Models\LogAktivitas;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{


    public function dashboard()
    {
        $stats = [
            'artikel' => Artikel::count(),
            'kegiatan' => Kegiatan::count(),
            'karya_siswa' => PosterSekolah::where('status', 'published')->count(),
            'comments' => Comment::count(),
            'likes' => Like::count(),
            'users' => User::count(),
            'kategoris' => Kategori::count()
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function comments()
    {
        $comments = Comment::with('artikel')->latest()->paginate(20);
        return view('admin.comments', compact('comments'));
    }

    public function likes()
    {
        $likes = Like::latest()->paginate(20);
        return view('admin.likes', compact('likes'));
    }

    public function reports(Request $request)
    {
        try {
            // Artikel yang sudah tayang per bulan
            $publishedByMonth = Artikel::where('status', 'published')
                ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as total')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->paginate(6, ['*'], 'month_page');
            
            // Artikel yang sudah tayang per kategori
            $publishedByCategory = Artikel::where('status', 'published')
                ->join('kategori', 'artikel.id_kategori', '=', 'kategori.id_kategori')
                ->selectRaw('kategori.nama_kategori, COUNT(*) as total')
                ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
                ->orderBy('total', 'desc')
                ->paginate(5, ['*'], 'category_page');
            
            // Total artikel published bulan ini
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $thisMonthPublished = Artikel::where('status', 'published')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
            
            // Artikel terbaru yang published
            $recentPublished = Artikel::where('status', 'published')
                ->with('kategori')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'article_page');
            
            // Poster published bulan ini
            $thisMonthPosters = PosterSekolah::where('status', 'published')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
            
            // Poster terbaru yang published
            $recentPosters = PosterSekolah::where('status', 'published')
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'poster_page');
            
            return view('admin.reports', compact('publishedByMonth', 'publishedByCategory', 'thisMonthPublished', 'recentPublished', 'thisMonthPosters', 'recentPosters'));
        } catch (\Exception $e) {
            $publishedByMonth = collect();
            $publishedByCategory = collect();
            $thisMonthPublished = 0;
            $recentPublished = collect();
            
            return view('admin.reports', compact('publishedByMonth', 'publishedByCategory', 'thisMonthPublished', 'recentPublished'))
                ->with('error', 'Beberapa data laporan tidak dapat dimuat.');
        }
    }
    
    public function exportPdf()
    {
        try {
            // Ambil data yang sama dengan halaman reports
            $publishedByMonth = Artikel::where('status', 'published')
                ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as total')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(12)
                ->get();
            
            $publishedByCategory = Artikel::where('status', 'published')
                ->join('kategori', 'artikel.id_kategori', '=', 'kategori.id_kategori')
                ->selectRaw('kategori.nama_kategori, COUNT(*) as total')
                ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
                ->orderBy('total', 'desc')
                ->get();
            
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $thisMonthPublished = Artikel::where('status', 'published')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
            
            $recentPublished = Artikel::where('status', 'published')
                ->with('kategori')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            
            $thisMonthPosters = PosterSekolah::where('status', 'published')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
            
            $recentPosters = PosterSekolah::where('status', 'published')
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            
            // Render view untuk PDF
            return view('admin.reports-pdf', compact('publishedByMonth', 'publishedByCategory', 'thisMonthPublished', 'recentPublished', 'thisMonthPosters', 'recentPosters'));
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengexport laporan: ' . $e->getMessage());
        }
    }
    
    public function exportExcel()
    {
        try {
            $publishedByMonth = Artikel::where('status', 'published')
                ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as total')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
            
            $publishedByCategory = Artikel::where('status', 'published')
                ->join('kategori', 'artikel.id_kategori', '=', 'kategori.id_kategori')
                ->selectRaw('kategori.nama_kategori, COUNT(*) as total')
                ->groupBy('kategori.id_kategori', 'kategori.nama_kategori')
                ->orderBy('total', 'desc')
                ->get();
            
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $thisMonthPublished = Artikel::where('status', 'published')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
            
            // Create CSV content with BOM for proper UTF-8 encoding
            $csv = "\xEF\xBB\xBF"; // UTF-8 BOM
            $csv .= "LAPORAN ARTIKEL E-MAGAZINE\n";
            $csv .= "Tanggal Export: " . \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') . " WIB\n\n";
            
            $csv .= "ARTIKEL PUBLISHED BULAN INI\n";
            $csv .= "Jumlah: {$thisMonthPublished}\n\n";
            
            $csv .= "ARTIKEL PER BULAN\n";
            $csv .= "Bulan,Tahun,Jumlah\n";
            foreach($publishedByMonth as $data) {
                $monthName = DateTime::createFromFormat('!m', $data->month)->format('F');
                $csv .= "\"{$monthName}\",{$data->year},{$data->total}\n";
            }
            
            $csv .= "\nARTIKEL PER KATEGORI\n";
            $csv .= "Kategori,Jumlah\n";
            foreach($publishedByCategory as $data) {
                $csv .= "\"{$data->nama_kategori}\",{$data->total}\n";
            }
            
            $thisMonthPosters = PosterSekolah::where('status', 'published')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();
            
            $recentPosters = PosterSekolah::where('status', 'published')
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            
            $csv .= "\nPOSTER PUBLISHED BULAN INI\n";
            $csv .= "Jumlah: {$thisMonthPosters}\n\n";
            
            $csv .= "POSTER TERBARU\n";
            $csv .= "Judul,Kategori,Penulis,Tanggal\n";
            foreach($recentPosters as $poster) {
                $csv .= "\"{$poster->judul}\",\"{$poster->kategori}\",\"{$poster->user->nama}\",{$poster->created_at->format('d/m/Y')}\n";
            }
            
            $filename = 'laporan-artikel-' . \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d-H-i-s') . '.csv';
            
            return response($csv)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Pragma', 'no-cache')
                ->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengexport Excel: ' . $e->getMessage());
        }
    }
    
    public function posterIndex()
    {
        $posters = PosterSekolah::with('user')->where('status', 'pending')->latest()->paginate(12);
        return view('admin.poster.index', compact('posters'));
    }
    
    public function posterPublish($id)
    {
        $poster = PosterSekolah::findOrFail($id);
        $poster->update(['status' => 'published']);
        
        // Log aktivitas
        LogAktivitas::create([
            'id_user' => Auth::user()->id_user,
            'aksi' => 'Mempublish poster: ' . $poster->judul
        ]);
        
        return back()->with('success', 'Poster berhasil dipublish!');
    }
}