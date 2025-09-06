<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stokbarang;

class BarangMasukController extends Controller
{
    public function index()
    {
        $stocks = stokbarang::with('supplier')->get();
        return view('barang_masuk.index', compact('stocks'));
    }
}
