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
}