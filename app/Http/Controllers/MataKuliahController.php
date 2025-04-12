<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliah = MataKuliah::all();
        return view('admin.mataKuliah', compact('mataKuliah'));
    }

    public function create()
    {
        return view('admin.createMataKuliah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        MataKuliah::create($request->all());
        return redirect()->route('admin.mataKuliah')->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        return view('admin.editMataKuliah', compact('mataKuliah'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->update($request->all());
        return redirect()->route('admin.mataKuliah')->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);

        if ($mataKuliah->users()->count() > 0) {
            return redirect()->route('admin.mataKuliah')->with('error', 'Mata Kuliah tidak dapat dihapus karena terkait dengan pengguna.');
        }

        $mataKuliah->delete();

        return redirect()->route('admin.mataKuliah')->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}
