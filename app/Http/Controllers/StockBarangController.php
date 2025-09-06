<?php

namespace App\Http\Controllers;

use App\Models\LogBarangKeluar;
use App\Models\LogSupplierPengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\stokbarang;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class StockBarangController extends Controller
{
    public function index()
    {
        $stocks = stokbarang::all();
        return view('StokBarang', compact('stocks'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', 'aktif')->get();
        return view('stokbarang.tambahBarang', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga_jual' => 'required',
            'harga_beli' => 'required',
            'stok' => 'required',
            'tgl_masuk' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'jenis_satuan' => 'required|in:pcs,pax,dus,kg',
        ]);

        $stok = stokbarang::create([
            'nama_barang' => $request->nama_barang,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli,
            'stok' => $request->stok,
            'tgl_masuk' => $request->tgl_masuk,
            'jumlah_barang_masuk' => $request->stok,
            'tipe_barang' => 'barang_masuk',
            'supplier_id' => $request->supplier_id,
            'jenis_satuan' => $request->jenis_satuan,
            'status' => 'aktif',
        ]);

        // Catat log aktivitas
        LogBarangKeluar::create([
            'stokbarang_id' => $stok->id,
            'user_id' => Auth::id(),
            'aksi' => 'barang_masuk',
            'deskripsi' => 'Menambahkan barang masuk: ' . $stok->nama_barang . ', jumlah: ' . $stok->stok,
        ]);

        // Simpan log pengiriman
        LogSupplierPengiriman::create([
            'supplier_id' => $request->supplier_id,
            'stokbarang_id' => $stok->id,
        ]);

        return redirect()->route('stokbarang.index')->with('success', 'Berhasil tambah stok barang');
    }

    public function edit($id)
    {
        $stocks = stokbarang::find($id);
        $suppliers = Supplier::where('status', 'aktif')->get();

        return view('stokbarang.editBarang', compact('stocks', 'suppliers'));
    }

    public function save($id, Request $request)
    {
        $stocks = stokbarang::find($id);

        $stocks->update($request->all());

        return redirect()->route('stokbarang.index')->with('success', 'Berhasil edit data barang');
    }

    public function delete($id)
    {
        $stocks = stokbarang::find($id);
        $stocks->delete();

        return redirect()->route('stokbarang.index')->with('success', 'Berhasil hapus data barang');
    }

    public function toggleStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        $barang = stokbarang::findOrFail($id);
        $barang->status = $request->status;
        $barang->save();

        return redirect()->route('stokbarang.index')->with('success', 'Status barang diperbarui.');
    }
}
