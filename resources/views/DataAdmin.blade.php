@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Data Admin</h1>
        <a href="{{ route('admin.tambah.data') }}" class="btn btn-primary mb-3">Tambah Data Admin</a>



        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>No Telp</th>
                                <th>Status</th>
                                <th>Alamat</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->username }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->no_telp }}</td>
                                    <td>{{ $admin->status }}</td>
                                    <td>{{ $admin->alamat }}</td>
                                    <td>
                                        <a href="{{ route('admin.edit', $admin->id) }}">Edit</a>
                                        <form action="{{ route('admin.delete', $admin->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
