<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $primaryKey = 'idpengajuan';

    protected $fillable = [
        'tanggal_pengajuan', 
        'status', 
        'users_id', 
        'jenisSurat_idjenisSurat'
    ];
}
