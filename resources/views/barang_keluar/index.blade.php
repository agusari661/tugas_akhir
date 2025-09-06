@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex flex-column justify-content-between">
            <div>
                <h1 class="h3 mb-2 text-gray-800">Barang Keluar</h1>
                <p class="mb-4">Data Barang Keluar</a>.</p>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Barang Keluar</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Harga Jual</th>
                                <th>Harga Beli</th>
                                <th>Stok Barang</th>
                                <th>Tanggal Keluar</th>
                                <th>Jumlah Barang Keluar</th>
                                <th>Nama Supplier</th>
                                {{-- <th>OPSI</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $stok)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $stok->nama_barang }}</td>
                                    <td>{{ $stok->harga_jual }}</td>
                                    <td>{{ $stok->harga_beli }}</td>
                                    <td>{{ $stok->stok }} {{ ucwords($stok->jenis_satuan) }}</td>
                                    <td>{{ $stok->tgl_keluar }}</td>
                                    <td>{{ $stok->jumlah_barang_keluar }} {{ ucwords($stok->jenis_satuan) }}</td>
                                    <td>{{ $stok->supplier->nama_supplier ?? 'Tidak Ada Supplier' }}</td>
                                    {{-- <td>
                                        <a href="{{ route('barangKeluar.edit', $stok->id) }}" class="btn btn-success">Edit</a>
                                    </td> --}}
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
