<?php

namespace App\Http\Controllers;

use App\Models\LogSupplierPengiriman;
use Illuminate\Http\Request;
use App\Models\stokbarang;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class EksekutifController extends Controller
{
    public function index(Request $request)
    {
        $startMonth = $request->get('start_month', now()->month);
        $endMonth = $request->get('end_month', now()->month);
        $year = $request->get('year', now()->year); // default tahun saat ini

        $barang = stokbarang::whereYear('created_at', $year)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])
            ->distinct('nama_barang') // Jika maksudnya "jumlah jenis"
            ->count('nama_barang');
        $totalBarangMasuk = stokbarang::whereYear('created_at', $year)->sum('jumlah_barang_masuk');
        $totalBarangKeluar = stokbarang::whereYear('created_at', $year)->sum('jumlah_barang_keluar');

        $barangMasuk = stokbarang::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('SUM(jumlah_barang_masuk) as total'))
            ->whereYear('created_at', $year)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan')
            ->toArray();

        $barangKeluar = stokbarang::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('SUM(jumlah_barang_keluar) as total'))
            ->whereYear('created_at', $year)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan')
            ->toArray();

        $labels = [];
        $dataMasuk = [];
        $dataKeluar = [];

        foreach (range($startMonth, $endMonth) as $bulan) {
            $labels[] = date('F', mktime(0, 0, 0, $bulan, 10));
            $dataMasuk[] = $barangMasuk[$bulan] ?? 0;
            $dataKeluar[] = $barangKeluar[$bulan] ?? 0;
        }

        $topBarangKeluar = stokbarang::select('nama_barang', 'stok', 'jenis_satuan', DB::raw('SUM(jumlah_barang_keluar) as total_keluar'))
            ->whereYear('created_at', $year)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])
            ->where('status', 'aktif')
            ->groupBy('nama_barang', 'stok', 'jenis_satuan')
            ->orderByDesc('total_keluar')
            ->limit(10)
            ->get();

        $topBarangTidakLaku = stokbarang::select('nama_barang', 'stok', 'jenis_satuan', DB::raw('SUM(jumlah_barang_keluar) as total_keluar'))
            ->whereYear('created_at', $year)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])
            ->where('status', 'aktif')
            ->groupBy('nama_barang', 'stok', 'jenis_satuan')
            ->orderBy('total_keluar', 'asc')
            ->limit(10)
            ->get();

        $topSupplier = LogSupplierPengiriman::select('suppliers.nama_supplier', DB::raw('COUNT(*) as total_pengiriman'))
            ->join('suppliers', 'log_supplier_pengiriman.supplier_id', '=', 'suppliers.id')
            ->whereYear('log_supplier_pengiriman.created_at', $year)
            ->whereBetween(DB::raw('MONTH(log_supplier_pengiriman.created_at)'), [$startMonth, $endMonth])
            ->where('suppliers.status', 'aktif')
            ->groupBy('suppliers.nama_supplier')
            ->orderByDesc('total_pengiriman')
            ->limit(10)
            ->get();

        $topBarangMahalTerlaku = stokbarang::select('nama_barang', 'harga_jual', 'stok', 'jenis_satuan', DB::raw('SUM(jumlah_barang_keluar) as total_keluar'))
            ->whereYear('created_at', $year)
            ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])
            ->where('status', 'aktif')
            ->groupBy('nama_barang', 'harga_jual', 'stok', 'jenis_satuan')
            ->orderByDesc(DB::raw('harga_jual * SUM(jumlah_barang_keluar)'))
            ->limit(10)
            ->get();

        return view('DashboardAdmin', compact('barang', 'totalBarangMasuk', 'totalBarangKeluar', 'labels', 'dataMasuk', 'dataKeluar', 'startMonth', 'endMonth', 'year', 'topBarangKeluar', 'topBarangTidakLaku', 'topSupplier', 'topBarangMahalTerlaku'));
    }

    public function ShowDataEkskutif()
    {
        return view('DataEksekutif');
    }

    public function cetakPDF(Request $request)
    {
        $startMonth = $request->get('start_month', 1);
        $endMonth = $request->get('end_month', 12);

        $barang = stokbarang::count();
        $totalBarangMasuk = stokbarang::sum('jumlah_barang_masuk');
        $totalBarangKeluar = stokbarang::sum('jumlah_barang_keluar');

        $barangMasuk = stokbarang::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('SUM(jumlah_barang_masuk) as total'))
            ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan')
            ->toArray();

        $barangKeluar = stokbarang::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('SUM(jumlah_barang_keluar) as total'))
            ->whereBetween(DB::raw('MONTH(created_at)'), [$startMonth, $endMonth])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->pluck('total', 'bulan')
            ->toArray();

        $labels = [];
        $dataMasuk = [];
        $dataKeluar = [];

        foreach (range($startMonth, $endMonth) as $bulan) {
            $labels[] = date('F', mktime(0, 0, 0, $bulan, 10));
            $dataMasuk[] = $barangMasuk[$bulan] ?? 0;
            $dataKeluar[] = $barangKeluar[$bulan] ?? 0;
        }

        $pdf = Pdf::loadView('pdf.cetak', compact('barang', 'totalBarangMasuk', 'totalBarangKeluar', 'labels', 'dataMasuk', 'dataKeluar', 'startMonth', 'endMonth'))->setPaper('a4', 'landscape');

        return $pdf->download('laporan-grafik-barang.pdf');
    }
}
