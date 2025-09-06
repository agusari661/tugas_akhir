<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Grafik Barang</title>
    <style>
        body { font-family: sans-serif; }
        .title { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        p { font-size: 14px; }
    </style>
</head>
<body>
    <h2 class="title">Laporan Grafik Barang<br>Dari Bulan {{ date('F', mktime(0, 0, 0, $startMonth, 10)) }} sampai {{ date('F', mktime(0, 0, 0, $endMonth, 10)) }}</h2>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Barang Masuk</th>
                <th>Barang Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($labels as $index => $bulan)
            <tr>
                <td>{{ $bulan }}</td>
                <td>{{ $dataMasuk[$index] }}</td>
                <td>{{ $dataKeluar[$index] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Barang Masuk:</strong> {{ $totalBarangMasuk }}</p>
    <p><strong>Total Barang Keluar:</strong> {{ $totalBarangKeluar }}</p>
</body>
</html>
