<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\mutasi_struk;

class pelanggan extends Model
{
    use HasFactory;
    
    // Tambahkan 2 baris ini
    protected $primaryKey = 'idpel'; 
    public $incrementing = false; 
    protected $keyType = 'string'; // Karena idpel biasanya angka panjang/string

    protected $fillable = [
        'idpel',
        'nama',
        'tarif_daya',
        'stand_meter'
    ];

    public function mutasi()
    {
        // Gunakan 'pelanggan_id' sebagai foreign key di mutasi_struks
        return $this->hasMany(mutasi_struk::class, 'pelanggan_id', 'idpel');
    }
}
