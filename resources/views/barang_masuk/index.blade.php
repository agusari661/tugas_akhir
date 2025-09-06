@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex flex-column justify-content-between">
            <div>
                <h1 class="h3 mb-2 text-gray-800">Barang Masuk</h1>
                <p class="mb-4">Cek Barang Masuk</a>.</p>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Barang Masuk</h6>
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
                                <th>Tanggal Masuk</th>
                                <th>Jumlah Barang Masuk</th>
                                <th>Nama Supplier</th>
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
                                    <td>{{ $stok->tgl_masuk }}</td>
                                    <td>{{ $stok->jumlah_barang_masuk }} {{ ucwords($stok->jenis_satuan) }}</td>
                                    <td>{{ $stok->supplier->nama_supplier ?? 'Tidak Ada Supplier' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
