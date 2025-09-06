@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Logs Aktivitas Barang</h2>
        <form method="GET" action="{{ route('log.barangkeluar') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <select name="nama_barang" id="nama_barang" class="form-select">
                    <option value="">-- Semua Barang --</option>
                    @foreach ($allBarang as $barang)
                        <option value="{{ $barang->id }}" {{ request('nama_barang') == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="tipe_barang" class="form-label">Status</label>
                <select name="tipe_barang" id="tipe_barang" class="form-select">
                    <option value="">-- Semua Status --</option>
                    <option value="barang_masuk" {{ request('tipe_barang') == 'barang_masuk' ? 'selected' : '' }}>Barang
                        Masuk</option>
                    <option value="update" {{ request('tipe_barang') == 'update' ? 'selected' : '' }}>Barang Keluar</option>
                </select>

            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('log.barangkeluar') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr style="text-align: center">
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli (Rp)</th>
                    <th>Harga Jual (Rp)</th>
                    <th>Supplier</th>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                    <th>Admin</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $index => $log)
                    <tr>
                        <td style="text-align: center">{{ $index + 1 }}</td>
                        <td style="text-align: center">{{ $log->barang->nama_barang ?? '-' }}</td>
                        <td style="text-align: right">{{ number_format($log->barang->harga_beli ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: right">{{ number_format($log->barang->harga_jual ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: center">{{ $log->barang->supplier->nama_supplier ?? '-' }}</td>
                        <td style="text-align: center">
                            @if ($log->aksi == 'update')
                                <span class="badge bg-danger text-white">Barang Keluar</span>
                            @elseif ($log->aksi == 'barang_masuk')
                                <span class="badge bg-success text-white">Barang Masuk</span>
                            @else
                                <span class="badge bg-secondary text-white">{{ ucfirst($log->aksi) }}</span>
                            @endif
                        </td>
                        <td style="text-align: center">{{ $log->deskripsi }}</td>
                        <td style="text-align: center">{{ $log->admin->name ?? '-' }}</td>
                        <td style="text-align: center">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
