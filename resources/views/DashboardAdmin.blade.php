@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Dashboard {{ Auth::user()->role === 'eksekutif' ? 'Eksekutif' : 'Admin' }}</h1>

        {{-- Card Summary --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-left-primary shadow">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Jenis Barang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $barang }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-success shadow">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Barang Masuk</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarangMasuk }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-danger shadow">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Barang Keluar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarangKeluar }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-warning shadow">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Top Barang Terjual</div>
                        <div class="h6 mb-0 text-gray-800">
                            @if ($topBarangKeluar->isNotEmpty())
                                {{ $topBarangKeluar->first()->nama_barang }}
                                ({{ $topBarangKeluar->first()->total_keluar }}
                                {{ ucwords($topBarangKeluar->first()->jenis_satuan) }})
                            @else
                                Tidak ada data
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->role === 'eksekutif')
            <form method="GET" action="{{ route('eksekutif.dashboard') }}" class="row align-items-end mb-4">
                <div class="col-md-3">
                    <label for="start_month" class="form-label">Dari Bulan</label>
                    <select name="start_month" id="start_month" class="form-control">
                        @foreach (range(1, 12) as $i)
                            <option value="{{ $i }}" {{ $startMonth == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="end_month" class="form-label">Sampai Bulan</label>
                    <select name="end_month" id="end_month" class="form-control">
                        @foreach (range(1, 12) as $i)
                            <option value="{{ $i }}" {{ $endMonth == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="year" class="form-label">Tahun</label>
                    <select name="year" id="year" class="form-control">
                        @foreach (range(now()->year, now()->year - 5) as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary mt-4">Filter</button>
                </div>
            </form>

            {{-- Top Barang Terjual Table --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">Top 10 Barang Paling Banyak Diminati</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered" style="text-align: center">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>Nama Barang</th>
                                        <th>Total Keluar</th>
                                        <th>Stok Barang Saat Ini</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topBarangKeluar as $barang)
                                        <tr>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->total_keluar }}</td>
                                            <td>{{ $barang->stok }} {{ strtoupper($barang->jenis_satuan) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Top 10 Barang Paling Tidak Laku --}}
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-danger">Top 10 Barang Paling Tidak Diminati</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Total Keluar</th>
                                        <th>Stok Barang Saat Ini</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topBarangTidakLaku as $barang)
                                        <tr>
                                            <td>{{ $barang->nama_barang }}</td>
                                            <td>{{ $barang->total_keluar }}</td>
                                            <td>{{ $barang->stok }} {{ strtoupper($barang->jenis_satuan) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Top 10 Supplier Paling Sering Kirim Barang --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-info">Top 10 Supplier Pengirim Barang</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered" style="text-align: center">
                                <thead>
                                    <tr>
                                        <th>Nama Supplier</th>
                                        <th>Total Pengiriman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topSupplier as $supplier)
                                        <tr>
                                            <td>{{ $supplier->nama_supplier }}</td>
                                            <td>{{ $supplier->total_pengiriman }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- Top 10 Barang Mahal Terlaku --}}
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-info">Top 10 Barang Terlaku Dan Termahal</h6>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>Nama Barang</th>
                                        <th>Harga Jual (Rp)</th>
                                        <th>Jumlah Terjual</th>
                                        <th>Total Penjualan (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topBarangMahalTerlaku as $barang)
                                        <tr>
                                            <td style="text-align: center">{{ ucwords($barang->nama_barang) }}</td>
                                            <td class="text-right">{{ number_format($barang->harga_jual, 0, ',', '.') }}
                                            </td>
                                            <td>{{ $barang->total_keluar }} {{ strtoupper($barang->jenis_satuan) }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($barang->harga_jual * $barang->total_keluar, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        @else
            <div class="row align-items-end mb-4">
                <form id="filterForm" method="GET" action="{{ route('admin.dashboard') }}" class="row w-100 gx-3">
                    <div class="col-md-3">
                        <label for="start_month" class="form-label">Dari Bulan</label>
                        <select name="start_month" id="start_month" class="form-control">
                            @foreach (range(1, 12) as $i)
                                <option value="{{ $i }}" {{ $startMonth == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="end_month" class="form-label">Sampai Bulan</label>
                        <select name="end_month" id="end_month" class="form-control">
                            @foreach (range(1, 12) as $i)
                                <option value="{{ $i }}" {{ $endMonth == $i ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-50">Filter</button>
                    </div>
                    <div class="col-md-4 d-flex align-items-end justify-content-end">
                        <a href="{{ route('admin.dashboard.cetak.pdf', ['start_month' => $startMonth, 'end_month' => $endMonth]) }}"
                            class="btn btn-danger">
                            <img src="https://cdn-icons-png.flaticon.com/16/337/337946.png" class="me-2"
                                alt="Download Icon">
                            Cetak PDF
                        </a>
                    </div>
                </form>
            </div>

            {{-- Charts --}}
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-success">Grafik Barang Masuk</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="barangMasukChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-danger">Grafik Barang Keluar</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="barangKeluarChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            let start = parseInt(document.getElementById('start_month').value);
            let end = parseInt(document.getElementById('end_month').value);

            if (start > end) {
                e.preventDefault(); // cegah form terkirim
                alert('Pilihan bulan tidak valid!\n"Dari Bulan" tidak boleh lebih besar dari "Sampai Bulan".');
            }
        });
    </script>
    
    <script>
        const ctxMasuk = document.getElementById('barangMasukChart').getContext('2d');
        new Chart(ctxMasuk, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Barang Masuk',
                    data: @json($dataMasuk),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctxKeluar = document.getElementById('barangKeluarChart').getContext('2d');
        new Chart(ctxKeluar, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Barang Keluar',
                    data: @json($dataKeluar),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    </div>
@endsection
