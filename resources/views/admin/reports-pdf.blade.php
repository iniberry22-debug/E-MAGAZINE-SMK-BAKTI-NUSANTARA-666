<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan E-Magazine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 28px;
        }
        .section {
            margin-bottom: 25px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            page-break-inside: avoid;
        }
        .section h3 {
            color: #007bff;
            margin-top: 0;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th {
            background: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        .stat-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
            text-align: center;
            margin: 10px 0;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }
        @media print {
            body { margin: 0; }
            .section { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN E-MAGAZINE</h1>
        <p><strong>Periode:</strong> {{ \Carbon\Carbon::now('Asia/Jakarta')->format('F Y') }}</p>
        <p><strong>Dicetak:</strong> {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }} WIB</p>
    </div>
    
    <div class="section">
        <h3>Artikel Published Bulan Ini</h3>
        <div class="stat-box">
            <div class="stat-number">{{ $thisMonthPublished }}</div>
            <div>Artikel</div>
        </div>
    </div>
    
    <div class="section">
        <h3>Poster Published Bulan Ini</h3>
        <div class="stat-box">
            <div class="stat-number">{{ $thisMonthPosters }}</div>
            <div>Poster</div>
        </div>
    </div>
    
    <div class="section">
        <h3>Artikel per Bulan</h3>
        <table>
            <tr>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah</th>
            </tr>
            @forelse($publishedByMonth as $data)
            <tr>
                <td>{{ DateTime::createFromFormat('!m', $data->month)->format('F') }}</td>
                <td>{{ $data->year }}</td>
                <td>{{ $data->total }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center;">Belum ada data</td>
            </tr>
            @endforelse
        </table>
    </div>
    
    <div class="section">
        <h3>Artikel per Kategori</h3>
        <table>
            <tr>
                <th>Kategori</th>
                <th>Jumlah</th>
            </tr>
            @forelse($publishedByCategory as $data)
            <tr>
                <td>{{ $data->nama_kategori }}</td>
                <td>{{ $data->total }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align: center;">Belum ada data</td>
            </tr>
            @endforelse
        </table>
    </div>

    <div class="section">
        <h3>Artikel Published Terbaru</h3>
        <table>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tanggal</th>
            </tr>
            @forelse($recentPublished as $article)
            <tr>
                <td>{{ Str::limit($article->judul, 50) }}</td>
                <td>{{ $article->kategori->nama_kategori ?? 'Tanpa Kategori' }}</td>
                <td>{{ $article->created_at ? $article->created_at->format('d/m/Y') : ($article->tanggal ? $article->tanggal->format('d/m/Y') : 'N/A') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center;">Belum ada artikel</td>
            </tr>
            @endforelse
        </table>
    </div>
    
    <div class="section">
        <h3>Poster Published Terbaru</h3>
        <table>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Tanggal</th>
            </tr>
            @forelse($recentPosters as $poster)
            <tr>
                <td>{{ Str::limit($poster->judul, 40) }}</td>
                <td>{{ $poster->kategori }}</td>
                <td>{{ $poster->user->nama ?? 'Unknown' }}</td>
                <td>{{ $poster->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center;">Belum ada poster</td>
            </tr>
            @endforelse
        </table>
    </div>
    
    <div class="footer">
        Laporan dibuat otomatis oleh Sistem E-Magazine pada {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>