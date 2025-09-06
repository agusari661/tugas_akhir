@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Data Admin</h1>
        {{-- nama, username, password, re-password, email, no telp, status, alamat --}}

        <div class="container-fluid">
            <form action="{{ route('admin.save', $admin->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Nama Admin..." value="{{ $admin->name }}">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Username..." value="{{ $admin->username }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email..." value="{{ $admin->email }}">
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">No Telp</label>
                    <input type="number" name="no_telp" class="form-control" id="no_telp" placeholder="No Telp..." value="{{ $admin->no_telp }}">
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-select" aria-label="Default select example">
                        <option value="menikah" {{ $admin->status == 'menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="belum_menikah" {{ $admin->status == 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Alamat..." value="{{ $admin->alamat }}">
                </div>
                <div>
                    <a href="" class="btn btn-primary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
