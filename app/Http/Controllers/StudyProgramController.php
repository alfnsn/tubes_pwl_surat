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
            'idstudy_program' => 'required|integer|unique:study_program,idstudy_program',
            'nama' => 'required|string|max:255',
        ]);

        StudyProgram::create($request->all());

        return redirect()->route('admin.studyProgram')->with('success', 'Study Program created successfully.');
    }

    public function edit($id)
    {
        $studyProgram = StudyProgram::findOrFail($id);
        return view('admin.editStudyProgram', compact('studyProgram'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $studyProgram = StudyProgram::findOrFail($id);
        $studyProgram->update($request->all());

        return redirect()->route('admin.studyProgram')->with('success', 'Study Program updated successfully.');
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
