<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StudyProgram;
use App\Models\Role;

class AdminController extends Controller
{
    public function pengguna()
    {
        $users = User::all();
        return view('admin.pengguna', compact('users'));
    }

    public function create()
    {
        return view('admin.createPengguna');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:users',
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'address' => 'required|max:300',
            'status' => 'required|max:12',
            'study_program_id' => 'required',
            'phone' => 'required|max:16',
            'role_id' => 'required',
        ]);

        try {
            $data = $request->all();
            $data['password'] = bcrypt($request->password);

            User::create($data);

            return redirect()->route('pengguna.' . strtolower($request->role))->with('success', 'Pengguna created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengguna')->with('error', 'Failed to create Pengguna.');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $studyPrograms = StudyProgram::all();
        $roles = Role::all();
        return view('admin.editPengguna', compact('user', 'studyPrograms', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'address' => 'required',
            'status' => 'required',
            'study_program_id' => 'required',
            'phone' => 'required',
            'role_id' => 'required',
        ]);

        $user = User::find($id);
        $user->update($request->all());

        $role = strtolower($user->role->name);

        return redirect()->route('pengguna.' . $role)->with('success', 'Pengguna updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $role = strtolower($user->role->name);
        $user->delete();
        return redirect()->route('pengguna.' . $role)->with('success', 'Pengguna deleted successfully.');
    }
}