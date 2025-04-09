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

        return redirect()->route('admin.studyProgram')->with('success', 'Study Program created successfully.');
    }

    public function edit($id)
    {
        $studyProgram = StudyProgram::find($id);

        if (!$studyProgram) {
            return redirect()->back()->with('error', 'Study Program with the specified ID does not exist.');
        }

        return view('admin.editStudyProgram', compact('studyProgram'));
    }

    public function update(Request $request, $id)
    {
        $studyProgram = StudyProgram::find($id);

        if (!$studyProgram) {
            return redirect()->back()->with('error', 'Study Program with the specified ID does not exist.');
        }

        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        try {
            $studyProgram->update($request->all());
            return redirect()->route('admin.studyProgram')->with('success', 'Study Program updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update Study Program.');
        }
    }

    public function destroy($id)
    {
        $studyProgram = StudyProgram::findOrFail($id);

        if ($studyProgram->users()->count() > 0) {
            return redirect()->route('admin.studyProgram')->with('error', 'Study Program cannot be deleted because it is associated with users.');
        }

        $studyProgram->delete();

        return redirect()->route('admin.studyProgram')->with('success', 'Study Program deleted successfully.');
    }
}
