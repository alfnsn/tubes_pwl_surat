<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory;
    protected $table = 'jenisSurat';
    protected $primaryKey = 'idJenisSurat';

    protected $fillable = [
        'name',
    ];
}