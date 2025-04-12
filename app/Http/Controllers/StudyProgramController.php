<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyProgram;

class StudyProgramController extends Controller
{
    public function index()
    {
        $studyPrograms = StudyProgram::all(['idstudy_program', 'nama']);
        return view('admin.studyProgram', compact('studyPrograms'));
    }

    public function create()
    {
        return view('admin.createStudyProgram');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        StudyProgram::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.studyProgram')->with('success', 'Program Studi berhasil dibuat.');
    }

    public function edit($id)
    {
        $studyProgram = StudyProgram::find($id);

        if (!$studyProgram) {
            return redirect()->back()->with('error', 'Program Studi dengan ID yang dimaksud tidak ditemukan.');
        }

        return view('admin.editStudyProgram', compact('studyProgram'));
    }

    public function update(Request $request, $id)
    {
        $studyProgram = StudyProgram::find($id);

        if (!$studyProgram) {
            return redirect()->back()->with('error', 'Program Studi dengan ID yang dimaksud tidak ditemukan.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        try {
            $studyProgram->update($request->all());
            return redirect()->route('admin.studyProgram')->with('success', 'Program Studi berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui Program Studi.');
        }
    }

    public function destroy($id)
    {
        $studyProgram = StudyProgram::findOrFail($id);

        if ($studyProgram->users()->count() > 0) {
            return redirect()->route('admin.studyProgram')->with('error', 'Program Studi tidak dapat dihapus karena terkait dengan pengguna.');
        }

        $studyProgram->delete();

        return redirect()->route('admin.studyProgram')->with('success', 'Program Studi berhasil dihapus.');
    }
}
