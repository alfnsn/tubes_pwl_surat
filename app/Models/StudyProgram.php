<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $table = 'study_program';
    protected $primaryKey = 'idstudy_program';

    protected $fillable = ['nama'];

    public function users()
    {
        return $this->hasMany(User::class, 'study_program_id', 'idstudy_program');
    }
}
