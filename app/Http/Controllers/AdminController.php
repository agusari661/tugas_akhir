<?php

namespace App\Http\Controllers;

use App\Models\stokbarang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
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

        $topBarangKeluar = stokbarang::select('nama_barang', 'stok', 'jenis_satuan', DB::raw('SUM(jumlah_barang_keluar) as total_keluar'))->where('status', 'aktif')->groupBy('nama_barang', 'stok', 'jenis_satuan')->orderByDesc('total_keluar')->limit(10)->get();

        $topBarangTidakLaku = stokbarang::select('nama_barang', 'stok', 'jenis_satuan', DB::raw('SUM(jumlah_barang_keluar) as total_keluar'))->where('status', 'aktif')->groupBy('nama_barang', 'stok', 'jenis_satuan')->orderBy('total_keluar', 'asc')->limit(10)->get();

        $topSupplier = Supplier::select('suppliers.nama_supplier', DB::raw('COUNT(stokbarang.id) as total_pengiriman'))->join('stokbarang', 'suppliers.id', '=', 'stokbarang.supplier_id')->groupBy('suppliers.nama_supplier')->orderByDesc('total_pengiriman')->limit(10)->get();

        return view('DashboardAdmin', compact('barang', 'totalBarangMasuk', 'totalBarangKeluar', 'labels', 'dataMasuk', 'dataKeluar', 'startMonth', 'endMonth', 'topBarangKeluar', 'topBarangTidakLaku', 'topSupplier'));
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

    public function ShowDataAdmin()
    {
        $admins = User::where('role', 'admin')->get();

        return view('DataAdmin', compact('admins'));
    }

    public function formAddDataAdmin()
    {
        return view('admin.tambahAdmin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'no_telp' => 'required|numeric|',
            'password' => 'required|string|min:3',
            'status' => 'required|in:menikah,belum_menikah',
            'alamat' => 'required|string|min:5',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('eksekutif.dashboard')->with('success', 'Berhassil tambah daata admin');
    }

    public function edit($id)
    {
        $admin = User::find($id);

        return view('admin.edit', compact('admin'));
    }

    public function save($id, Request $request)
    {
        $admin = User::find($id);

        $admin->update($request->all());

        return redirect()->route('eksekutif.dashboard')->with('success', 'Berhasil edit daata admin');
    }

    public function delete($id)
    {
        $admin = User::find($id);
        $admin->delete();

        return redirect()->route('eksekutif.dashboard')->with('success', 'Berhasil edit daata admin');
    }
}
