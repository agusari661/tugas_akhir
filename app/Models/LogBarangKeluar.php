<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogBarangKeluar extends Model
{
    protected $table = 'log_barang_keluar';

    protected $fillable = ['stokbarang_id', 'user_id', 'aksi', 'deskripsi'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barang()
    {
        return $this->belongsTo(stokbarang::class, 'stokbarang_id');
    }
}
