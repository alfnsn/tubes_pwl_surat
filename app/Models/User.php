<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'address',
        'status',
        'phone',
        'email',
        'password',
        'profile_picture',
        'semester',
        'remember_token',
        'role_id',
        'study_program_id',
    ];

    public $incrementing = false; // Nonaktifkan auto-increment
    protected $keyType = 'string'; // Ubah tipe primary key menjadi string

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isRole($roleId){
        return $this->role_id == $roleId;
    }
    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id');
    }

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'users_id', 'id');
    }


}
