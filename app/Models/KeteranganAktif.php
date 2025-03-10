<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeteranganAktif extends Model
{
    use HasFactory;
    protected $table = 'keteranganAktif';
    protected $primaryKey = 'idketeranganAktif';

    protected $fillable = [
        'semester',
        'alamat_bandung',
        'keperluan_pengajuan',
        'created_at',
        'updated_at',
        'pengajuan_idpengajuan'
    ];
}
