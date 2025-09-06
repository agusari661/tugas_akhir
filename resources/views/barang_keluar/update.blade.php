@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Data Barang Keluar</h1>

    <div class="container-fluid">
        {{-- Tampilkan error validasi jika ada --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Arahkan ke route yang benar. Gunakan method POST. --}}
        <form action="{{ route('barangKeluar.save') }}" method="POST">
            @csrf
            {{-- Karena kita mengupdate data, method PUT lebih cocok secara semantik --}}
            @method('PUT') 

            <div class="mb-3">
                <label for="produk_id" class="form-label">Nama Produk</label>
                {{-- UBAH name dari "nama_barang" menjadi "produk_id" --}}
                <select name="produk_id" id="produk_id" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($stocks as $produk)
                        {{-- Tampilkan juga sisa stok agar informatif --}}
                        <option value="{{ $produk->id }}" {{ old('produk_id') == $produk->id ? 'selected' : '' }}>
                            {{ $produk->nama_barang }} (Stok: {{ $produk->stok }} {{ ucwords($produk->jenis_satuan) }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="tgl_keluar" class="form-label">Tanggal Keluar</label>
                <input type="date" name="tgl_keluar" class="form-control" id="tgl_keluar" value="{{ old('tgl_keluar', date('Y-m-d')) }}" required>
            </div>
            <div class="mb-3">
                <label for="jumlah_barang_keluar" class="form-label">Jumlah Barang Keluar</label>
                {{-- Ubah nama input agar konsisten (lowercase) --}}
                <input type="number" name="jumlah_barang_keluar" class="form-control" id="jumlah_barang_keluar" placeholder="Jumlah Barang Keluar..." value="{{ old('jumlah_barang_keluar') }}" required>
            </div>
            <div>
                <a href="{{ route('stokbarang.index') }}" class="btn btn-primary">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection