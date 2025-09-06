@extends('layouts.admin')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-flex flex-column justify-content-between">
            <div>
                <h1 class="h3 mb-2 text-gray-800">Data Supplier</h1>
                <p class="mb-4">Cek Data Supplier</a>.</p>
            </div>
            @if (Auth::user()->role === 'admin')
                <div>
                    <a href="{{ route('supplier.create') }}" class="btn btn-primary mb-3">Tambah Data Supplier</a>
                </div>
            @else
            @endif
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Supplier</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Supplier</th>
                                <th>Email</th>
                                <th>No Telp</th>
                                <th>Alamat</th>
                                @if (Auth::user()->role === 'admin')
                                    <th>OPSI</th>
                                    <th>Status</th>
                                @else
                                    <th>Status</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supllier)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $supllier->nama_supplier }}</td>
                                    <td>{{ $supllier->email }}</td>
                                    <td>{{ $supllier->no_telp }}</td>
                                    <td>{{ $supllier->alamat }}</td>
                                    @if (Auth::user()->role === 'admin')
                                        <td class="d-flex">
                                            <a href="{{ route('supplier.edit', $supllier->id) }}"
                                                class="btn btn-success mr-2">Edit</a>
                                            {{-- <form action="{{ route('supplier.delete', $supllier->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                Hapus
                                            </button>
                                        </form> --}}
                                        </td>
                                        <td>
                                            <form action="{{ route('supplier.toggleStatus', $supllier->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status"
                                                    class="form-select form-select-sm border-0 bg-light p-1"
                                                    style="width: auto;" onchange="this.form.submit()">
                                                    <option value="aktif"
                                                        {{ $supllier->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="tidak aktif"
                                                        {{ $supllier->status === 'tidak aktif' ? 'selected' : '' }}>Tidak
                                                        Aktif</option>
                                                </select>
                                            </form>
                                        </td>
                                    @else
                                        <td>
                                            <select name="status" class="form-select form-select-sm border-0 bg-light p-1"
                                                style="width: auto;" onchange="this.form.submit()" disabled>
                                                <option value="aktif"
                                                    {{ $supllier->status === 'aktif' ? 'selected' : '' }}>Aktif
                                                </option>
                                                <option value="tidak aktif"
                                                    {{ $supllier->status === 'tidak aktif' ? 'selected' : '' }}>Tidak
                                                    Aktif</option>
                                            </select>
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
@endsection
