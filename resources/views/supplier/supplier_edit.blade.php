@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Data Supplier</h1>

        <div class="container-fluid">
            <form action="{{ route('supplier.save', $suppliers->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="nama_supplier" class="form-label">Nama Supplier</label>
                    <input type="text" name="nama_supplier" class="form-control" id="nama_supplier" placeholder="Nama Supplier..." value="{{ $suppliers->nama_supplier }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email..." value="{{ $suppliers->email }}" required>
                </div>
                <div class="mb-3">
                    <label for="no_telp" class="form-label">No Telp</label>
                    <input type="number" name="no_telp" class="form-control" id="no_telp" placeholder="No Telp..." value="{{ $suppliers->no_telp }}" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Tanggal Masuk..." value="{{ $suppliers->alamat }}" required>
                </div>
                <div>
                    <a href="{{ route('supplier.index') }}" class="btn btn-primary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
