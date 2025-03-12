<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'address' => 'required',
            'status' => 'required',
            'study_program' => 'required',
            'phone' => 'required',
            'role' => 'required',
        ]);

        User::create($request->all());

        return redirect()->route('admin.pengguna')->with('success', 'Pengguna created successfully.');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.editPengguna', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'address' => 'required',
            'status' => 'required',
            'study_program' => 'required',
            'phone' => 'required',
            'role' => 'required',
        ]);

        $user = User::find($id);
        $user->update($request->all());

        return redirect()->route('admin.pengguna')->with('success', 'Pengguna updated successfully.');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('admin.pengguna')->with('success', 'Pengguna deleted successfully.');
    }
}