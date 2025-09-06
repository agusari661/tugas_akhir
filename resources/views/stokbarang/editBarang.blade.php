@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Data Produk</h1>

        <div class="container-fluid">
            <form id="produkForm" action="{{ route('stokbarang.save', $stocks->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" id="nama_barang"
                        placeholder="Nama Barang..." value="{{ $stocks->nama_barang }}" required>
                </div>
                <div class="mb-3">
                    <label for="harga_jual" class="form-label">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" id="harga_jual" placeholder="Harga Jual..."
                        value="{{ $stocks->harga_jual }}" id="harga_jual" required>
                </div>
                <div class="mb-3">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" id="harga_beli" placeholder="Harga Beli..."
                        value="{{ $stocks->harga_beli }}" id="harga_beli" required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok Barang</label>
                    <input type="number" name="stok" class="form-control" id="stok" placeholder="Harga Beli..."
                        value="{{ $stocks->stok }}" required>
                </div>
                <div class="mb-3">
                    <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tgl_masuk" class="form-control" id="tgl_masuk"
                        placeholder="Tanggal Masuk..." value="{{ $stocks->tgl_masuk }}"> required
                </div>
                <div class="mb-3">
                    <label for="supplier_id" class="form-label">Supplier</label>
                    <select name="supplier_id" id="supplier_id" class="form-select" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ $stocks->supplier_id == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->nama_supplier }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <a href="{{ route('stokbarang.index') }}" class="btn btn-primary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('produkForm').addEventListener('submit', function(e) {
            let hargaJual = parseFloat(document.getElementById('harga_jual').value) || 0;
            let hargaBeli = parseFloat(document.getElementById('harga_beli').value) || 0;

            if (hargaJual < hargaBeli) {
                e.preventDefault(); // batalkan submit
                alert('Harga jual tidak boleh lebih murah dari harga beli!');
            }
        });
    </script>
@endsection
