<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $table = 'surat';
    protected $primaryKey = 'idsurat';

    protected $fillable = [
        'file_path',
        'uploaded_date',
        'pengajuan_idpengajuan',
    ];
}