<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanHasilStudi extends Model
{
    use HasFactory;
    protected $table = 'laporanHasilStudi';
    protected $primaryKey = 'idlaporanHasilStudi';

    protected $fillable = [
        'keperluan_pembuatan',
        'pengajuan_idpengajuan'
    ];
}