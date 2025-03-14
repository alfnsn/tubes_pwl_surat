<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMahasiswa extends Model
{
    use HasFactory;
    protected $table = 'dataMahasiswa';
    protected $primaryKey = 'nrp';
    protected $keyType = 'string';
    public $incrementing = false; 

    protected $fillable = [
        'nrp',
        'nama',
    ];

    public function pengantarMK()
    {
        return $this->belongsToMany(PengantarMataKuliah::class, 'dataMahasiswa_has_pengantarMK', 'dataMahasiswa_nrp', 'pengantarMK_idpengantarMK');
    }
}
