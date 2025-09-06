<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSupplierPengiriman extends Model
{
    use HasFactory;

    protected $table = 'log_supplier_pengiriman';

    protected $fillable = [
        'supplier_id',
        'stokbarang_id',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stokbarang()
    {
        return $this->belongsTo(stokbarang::class);
    }
}
