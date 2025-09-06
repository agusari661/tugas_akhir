<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stokbarang extends Model
{
    protected $table = 'stokbarang';

    protected $fillable = ['nama_barang', 'harga_jual', 'harga_beli', 'stok', 'jenis_satuan', 'tgl_masuk', 'tgl_keluar', 'jumlah_barang_masuk', 'jumlah_barang_keluar', 'gambar', 'tipe_barang', 'supplier_id', 'status'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
