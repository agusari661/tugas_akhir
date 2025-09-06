<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['nama_supplier', 'email', 'no_telp', 'alamat'];

    public function stokbarang()
    {
        return $this->hasMany(Stokbarang::class, 'supplier_id');
    }
}
