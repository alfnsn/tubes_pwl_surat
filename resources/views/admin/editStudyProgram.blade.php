@extends('layouts.indexAdmin')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-2 text-gray-800">Edit Program Studi</h1>
        </div>

        <!-- Form Example -->
        <div class="card shadow mb-4">

            <div class="card-body">
                <form action="{{ route('admin.studyProgram.update', ['id' => $studyProgram->idstudy_program]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="nama"
                            value="{{ $studyProgram->nama }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
