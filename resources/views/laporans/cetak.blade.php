<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Analisis Pertumbuhan Balita</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; }
        .subtitle { font-size: 14px; margin: 5px 0 0 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">POSYANDU CARE</h1>
        <p class="subtitle">Laporan Analisis Pertumbuhan Balita</p>
        <p class="subtitle">Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Nama Balita</th>
                <th>NIK</th>
                <th>Umur (Bln)</th>
                <th>BB (kg)</th>
                <th>TB (cm)</th>
                <th>Status Pertumbuhan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemeriksaans as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_pemeriksaan)->format('d/m/Y') }}</td>
                <td>{{ $item->balita->nama }}</td>
                <td>{{ $item->balita->nik }}</td>
                <td class="text-center">{{ $item->umur_bulan }}</td>
                <td class="text-center">{{ $item->berat_badan }}</td>
                <td class="text-center">{{ $item->tinggi_badan }}</td>
                <td>{{ $item->status_pertumbuhan ?? 'Belum Dianalisis' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
