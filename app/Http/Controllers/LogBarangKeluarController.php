<?php

namespace App\Http\Controllers;

use App\Models\LogBarangKeluar;
use App\Models\stokbarang;
use Illuminate\Http\Request;

class LogBarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = LogBarangKeluar::with(['admin', 'barang.supplier']);

        // Filter berdasarkan nama barang
        if ($request->filled('nama_barang')) {
            $query->whereHas('barang', function ($q) use ($request) {
                $q->where('id', $request->nama_barang);
            });
        }

        // Filter berdasarkan status barang masuk / keluar
        if ($request->filled('tipe_barang')) {
            $query->where('aksi', $request->tipe_barang);
        }

        $logs = $query->latest()->get();

        // Semua barang untuk dropdown filter
        $allBarang = stokbarang::select('id', 'nama_barang')->orderBy('nama_barang')->get();

        return view('logs.barangkeluar', compact('logs', 'allBarang'));
    }
}
