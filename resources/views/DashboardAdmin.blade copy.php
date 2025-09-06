@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard {{ Auth::user()->role === 'eksekutif' ? 'Eksekutif' : 'Admin' }}</h1>

    {{-- Card Summary --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-left-primary shadow">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Barang</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $barang }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-success shadow">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Barang Masuk</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarangMasuk }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-left-danger shadow">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Barang Keluar</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBarangKeluar }}</div>
                </div>
            </div>
        </div>
    </div>

 <div class="row align-items-end mb-4">
    <form method="GET" action="{{ route('eksekutif.dashboard') }}" class="row w-100 gx-3">
        <div class="col-md-3">
            <label for="start_month" class="form-label">Dari Bulan</label>
            <select name="start_month" id="start_month" class="form-control">
                @foreach(range(1,12) as $i)
                    <option value="{{ $i }}" {{ $startMonth == $i ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="end_month" class="form-label">Sampai Bulan</label>
            <select name="end_month" id="end_month" class="form-control">
                @foreach(range(1,12) as $i)
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
            <a href="{{ route('eksekutif.dashboard.cetak.pdf', ['start_month' => $startMonth, 'end_month' => $endMonth]) }}" class="btn btn-danger">
                <img src="https://cdn-icons-png.flaticon.com/16/337/337946.png" class="me-2" alt="Download Icon">
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
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                y: { beginAtZero: true }
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
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
