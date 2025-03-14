<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\StudyProgram;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
  public function create(Request $request)
  {
      $roles = Role::all();
      $studyPrograms = StudyProgram::all();
      $role = $request->query('role');
      $roleId = Role::where('name', $role)->first()->id;
  
      return view('admin.createPengguna', compact('roles', 'studyPrograms', 'role', 'roleId'));
  }
  

    public function showMahasiswa()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'Mahasiswa');
        })->get();

        return view('admin.pengguna', compact('users'));
    }

    public function showKaprodi()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'Kaprodi');
        })->get();

        return view('admin.pengguna', compact('users'));
    }

    public function showMo()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'MO');
        })->get();

        return view('admin.pengguna', compact('users'));
    }

    public function showAdmin()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'Admin');
        })->get();

        return view('admin.pengguna', compact('users'));
    }

    // ...existing code...
}