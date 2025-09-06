<?php

namespace App\Http\Controllers;

use App\Models\LogBarangKeluar;
use Illuminate\Http\Request;
use App\Models\stokbarang;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $stocks = stokbarang::with('supplier')->where('tipe_barang', 'barang_keluar')->get();
        return view('barang_keluar.index', compact('stocks'));
    }

    public function update()
    {
        $stocks = stokbarang::with('supplier')->where('status', 'aktif')->get();
        return view('barang_keluar.update', compact('stocks'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:stokbarang,id',
            'tgl_keluar' => 'required|date',
            'jumlah_barang_keluar' => 'required|integer|min:1',
        ]);

        $produk = stokbarang::find($request->produk_id);

        if (!$produk) {
            return back()->withErrors('Produk tidak ditemukan');
        }

        if ($produk->stok < $request->jumlah_barang_keluar) {
            return back()
                ->withInput()
                ->withErrors(['jumlah_barang_keluar' => 'Stok tidak mencukupi. Stok saat ini: ' . $produk->stok]);
        }

        // Simpan data lama untuk log
        $jumlahSebelum = $produk->jumlah_barang_keluar ?? 0;

        // Kurangi stok utama
        $produk->stok -= $request->jumlah_barang_keluar;

        // Tambah kumulatif jumlah_barang_keluar
        $produk->jumlah_barang_keluar = $jumlahSebelum + $request->jumlah_barang_keluar;

        // Update tanggal & tipe
        $produk->tgl_keluar = $request->tgl_keluar;
        $produk->tipe_barang = 'barang_keluar';

        $produk->save();

        // ✅ Simpan log aktivitas barang keluar
        LogBarangKeluar::create([
            'stokbarang_id' => $produk->id,
            'user_id' => Auth::id(),
            'aksi' => 'update',
            'deskripsi' => "Barang keluar diperbarui oleh admin. Jumlah keluar: {$request->jumlah_barang_keluar}",
        ]);

        return redirect()->route('stokbarang.index')->with('success', 'Data barang keluar berhasil disimpan');
    }

    public function logBarangKeluar()
    {
        $logs = LogBarangKeluar::with(['admin', 'stokbarang'])->latest()->get();
        return view('logs.barangkeluar', compact('logs'));
    }
}
