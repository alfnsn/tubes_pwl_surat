<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role'; // Nama tabel di database

    protected $fillable = ['name']; // Kolom yang bisa diisi

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
