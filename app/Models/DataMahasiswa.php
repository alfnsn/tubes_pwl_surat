<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataMahasiswa extends Model
{
    use HasFactory;
    protected $table = 'dataMahasiswa';
    protected $primaryKey = 'iddataMahasiswa';

    protected $fillable = [
        'nama',
        'nrp',
        'pengantarMK_idpengantarMK'
    ];
}
