<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah';
    protected $primaryKey = 'idmata_kuliah';

    protected $fillable = ['nama'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_has_mata_kuliah','mata_kuliah_idmata_kuliah', 'users_id');
    }
}
