<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeteranganLulus extends Model
{
    use HasFactory;
    protected $table = 'keteranganLulus';
    protected $primaryKey = 'idketeranganLulus';

    protected $fillable = [
        'tanggal_kelulusan',
        'pengajuan_idpengajuan'
    ];
}