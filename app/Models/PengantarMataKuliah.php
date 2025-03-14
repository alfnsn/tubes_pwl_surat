<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengantarMataKuliah extends Model
{
    use HasFactory;
    protected $table = 'pengantarMK';
    protected $primaryKey = 'idpengantarMK';

    protected $fillable = [
        'ditujukan',
        'nama_kode_mk',
        'semester',
        'tujuan',
        'topik', 
        'pengajuan_idpengajuan'
    ];

    public function mahasiswa()
    {
        return $this->belongsToMany(DataMahasiswa::class, 'dataMahasiswa_has_pengantarMK', 'pengantarMK_idpengantarMK', 'dataMahasiswa_nrp');
    }
}