@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3 class="mb-4">Update Stok Barang</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('stok.update') }}">
            @csrf
            <div class="mb-3">
                <label for="stokbarang_id" class="form-label">Nama Barang</label>
                <select name="stokbarang_id" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }} (Stok: {{ $barang->stok }})</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah_tambahan" class="form-label">Jumlah Tambahan Stok</label>
                <input type="number" name="jumlah_tambahan" class="form-control" required min="1">
            </div>

            <button type="submit" class="btn btn-primary">Update Stok</button>
        </form>

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

    </div>
@endsection
