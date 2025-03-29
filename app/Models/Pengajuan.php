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
        'disetujui_oleh',
        'path_template',
        'users_id',
        'jenisSurat_idjenisSurat'
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenisSurat_idjenisSurat', 'idjenisSurat');
    }

    public function keteranganAktif()
    {
        return $this->hasOne(KeteranganAktif::class, 'pengajuan_idpengajuan');
    }

    public function keteranganLulus()
    {
        return $this->hasOne(KeteranganLulus::class, 'pengajuan_idpengajuan' );
    }

    public function laporanHasilStudi()
    {
        return $this->hasOne(LaporanHasilStudi::class, 'pengajuan_idpengajuan' );
    }
    public function pengantarMataKuliah()
    {
        return $this->hasOne(PengantarMataKuliah::class, 'pengajuan_idpengajuan');
    }

    public function surat()
    {
        return $this->hasOne(Surat::class, 'pengajuan_idpengajuan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
