<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\pelanggan;

class mutasi_struk extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'periode',
        'tagihan',
        'biaya_admin'
    ];

    public function pelanggan()
    {
        // pelanggan_id adalah kolom di tabel mutasi_struks
        // idpel adalah kolom kunci di tabel pelanggans
        return $this->belongsTo(pelanggan::class, 'pelanggan_id', 'idpel');
    }
}
