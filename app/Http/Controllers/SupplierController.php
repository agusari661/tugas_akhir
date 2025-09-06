<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.supplier_index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.supplier_tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'email' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Berhasil tambah data supplier');
    }

    public function edit($id)
    {
        $suppliers = Supplier::find($id);

        return view('supplier.supplier_edit', compact('suppliers'));
    }

    public function save($id, Request $request)
    {
        $suppliers = Supplier::find($id);

        $suppliers->update($request->all());

        return redirect()->route('supplier.index')->with('success', 'Berhasil edit data supplier');
    }

    public function delete($id)
    {
        $suppliers = Supplier::find($id);
        $suppliers->delete();

        return redirect()->route('supplier.index')->with('success', 'Berhasil hapus data supplier');
    }

    public function toggleStatus(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:aktif,tidak aktif',
        ]);

        $supplier->status = $validated['status'];
        $supplier->save();

        return redirect()->back()->with('success', 'Status supplier berhasil diperbarui');
    }
}
