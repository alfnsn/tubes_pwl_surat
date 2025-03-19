<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'idnotifikasi';

    protected $fillable = [
        'pesan',
        'status',
        'tujuan',
        'users_id',
        'pengajuan_idpengajuan',
        'created_at',
        'updated_at',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    // Relasi ke Pengajuan
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_idpengajuan', 'idpengajuan');
    }
}
