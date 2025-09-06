<?php

namespace App\Http\Controllers;

use App\Models\LogBarangKeluar;
use App\Models\stokbarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokUpdateController extends Controller
{
    public function form()
    {
        $barangs = stokbarang::orderBy('nama_barang')->where('status', 'aktif')->get();
        return view('stokbarang.updateStok', compact('barangs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'stokbarang_id' => 'required|exists:stokbarang,id',
            'jumlah_tambahan' => 'required|integer|min:1',
        ]);

        $barang = stokbarang::findOrFail($request->stokbarang_id);
        $stok_lama = $barang->stok;
        $barang->stok += $request->jumlah_tambahan;
        $barang->jumlah_barang_masuk = ($barang->jumlah_barang_masuk ?? 0) + $request->jumlah_tambahan;
        $barang->save();

        // Simpan ke log
        LogBarangKeluar::create([
            'stokbarang_id' => $barang->id,
            'user_id' => Auth::id(),
            'aksi' => 'barang_masuk',
            'deskripsi' => "Update stok: dari $stok_lama menjadi {$barang->stok} (+{$request->jumlah_tambahan})",
        ]);

        return redirect()->route('stok.update.form')->with('success', 'Stok berhasil diperbarui');
    }
}
