@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Tambah Data Produk</h1>

        <div class="container-fluid">
            <form id="produkForm" action="{{ route('stokbarang.store') }}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" id="nama_barang"
                        placeholder="Nama Barang..." required>
                </div>
                <div class="mb-3">
                    <label for="harga_jual" class="form-label">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" id="harga_jual"
                        placeholder="Harga Jual..." required>
                </div>
                <div class="mb-3">
                    <label for="harga_beli" class="form-label">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" id="harga_beli"
                        placeholder="Harga Beli..." required>
                </div>
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" id="stok" placeholder="Stok Barang..." required>
                </div>
                <div class="mb-3">
                    <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" name="tgl_masuk" class="form-control" id="tgl_masuk"
                        placeholder="Tanggal Masuk..." required>
                </div>
                <div class="mb-3">
                    <label for="supplier_id" class="form-label">Nama Supplier</label>
                    <select name="supplier_id" class="form-control" id="supplier_id" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jenis_satuan" class="form-label">Jenis Barang (Satuan)</label>
                    <select name="jenis_satuan" class="form-control" id="jenis_satuan" required>
                        <option value="">-- Pilih Satuan --</option>
                        <option value="pcs">PCS</option>
                        <option value="pax">PAX</option>
                        <option value="dus">DUS</option>
                        <option value="kg">KG</option>
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
