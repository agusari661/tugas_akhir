@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex flex-column justify-content-between">
            <div>
                <h1 class="h3 mb-2 text-gray-800"> Stok Barang</h1>
                <p class="mb-4">Cek Stok Barang</a>.</p>
            </div>
            @if (Auth::user()->role === 'admin')
                <div>
                    <a href="{{ route('stokbarang.create') }}" class="btn btn-primary mb-3">Tambah Barang Baru</a>
                    <a href="{{ route('barangKeluar.update') }}" class="btn btn-danger mb-3">Edit Barang Keluar</a>
                    <a href="{{ route('stok.update') }}" class="btn btn-success mb-3">Tambah Stock Barang</a>
                </div>
            @else
            @endif
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Stok Barang</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr style="text-align: center">
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Harga Jual (Rp)</th>
                                <th>Harga Beli (Rp)</th>
                                <th>Stok Barang</th>
                                <th>Tanggal Masuk</th>
                                <th>Nama Supplier</th>
                                @if (Auth::user()->role === 'admin')
                                    <th>OPSI</th>
                                @else
                                @endif
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $stok)
                                <tr>
                                    <td style="text-align: center">{{ $loop->iteration }}</td>
                                    <td style="text-align: center">{{ $stok->nama_barang }}</td>
                                    {{-- <td>{{ $stok->harga_jual }}</td> --}}
                                    <td class="text-right">{{ number_format($stok->harga_jual, 0, ',', '.') }}</td>
                                    {{-- <td>{{ $stok->harga_beli }}</td> --}}
                                    <td class="text-right">{{ number_format($stok->harga_beli, 0, ',', '.') }}</td>
                                    <td style="text-align: center">{{ $stok->stok }} {{ ucwords($stok->jenis_satuan) }}
                                    </td>
                                    <td style="text-align: center">{{ $stok->tgl_masuk }}</td>
                                    <td style="text-align: center">
                                        {{ $stok->supplier->nama_supplier ?? 'Tidak Ada Supplier' }}</td>
                                    @if (Auth::user()->role === 'admin')
                                        <td class="d-flex">
                                            <a href="{{ route('stokbarang.edit', $stok->id) }}"
                                                class="btn btn-success mr-2">Edit</a>
                                            {{-- <form action="{{ route('stokbarang.delete', $stok->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                Hapus
                                            </button>
                                        </form> --}}
                                        <td>
                                            <form action="{{ route('stokbarang.toggleStatus', $stok->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status"
                                                    class="form-select form-select-sm border-0 bg-light p-1"
                                                    style="width: auto;" onchange="this.form.submit()">
                                                    <option value="aktif"
                                                        {{ $stok->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="tidak aktif"
                                                        {{ $stok->status == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                        </td>
                                    @else
                                        <td>
                                            <form>
                                                <select name="status"
                                                    class="form-select form-select-sm border-0 bg-light p-1"
                                                    style="width: auto;" disabled>
                                                    <option value="aktif"
                                                        {{ $stok->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="tidak aktif"
                                                        {{ $stok->status == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endsection
